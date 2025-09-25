<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Models\Usuario;
use App\Models\Producto;
use App\Models\Pedido;

class PedidoController extends Controller
{
        public function index(Request $request)
    {
        // Verificar si es una solicitud de dashboard
        if ($request->is('pedidos/dashboard') || $request->has('dashboard')) {
            return $this->dashboardData();
        }

        // Lógica normal del index
        $query = Pedido::with(['usuario', 'producto']);

        if ($request->filled('estado')) {
            $query->where('estPed', $request->input('estado'));
        }

        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function($q) use ($buscar) {
                $q->whereHas('usuario', function ($subQ) use ($buscar) {
                    $subQ->where('nomUsu', 'like', "%$buscar%")
                        ->orWhere('apeUsu', 'like', "%$buscar%");
                })->orWhereHas('producto', function ($subQ) use ($buscar) {
                    $subQ->where('nomPro', 'like', "%$buscar%");
                })->orWhere('estPed', 'like', "%$buscar%");
            });
        }

        $pedidos = $query->orderBy('fecPed', 'desc')->paginate(10);
        
        return view('admin.pedidos.index', [
            'pedidos' => $pedidos,
            'estadisticas' => $this->getEstadisticas()
        ]);
    }

    // Nuevo método para datos del dashboard
    protected function getSalesData()
    {
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        // Crear colección de fechas base
        $dates = collect();
        for ($i = 0; $i <= 6; $i++) {
            $dates->put($startDate->copy()->addDays($i)->format('Y-m-d'), 0);
        }

        // Obtener datos usando el cast de fecha
        $pedidosData = Pedido::whereBetween('fecPed', [$startDate, $endDate])
            ->get()
            ->groupBy(function ($pedido) {
                return $pedido->fecPed->format('Y-m-d');
            })
            ->map->count();

        return $dates->merge($pedidosData)->map(function ($count, $date) {
            return [
                'date' => Carbon::parse($date)->isoFormat('D MMM'),
                'count' => $count
            ];
        })->values();
    }

    // Método para obtener estadísticas
    protected function getEstadisticas()
    {
        return [
            'total' => Pedido::count(),
            'por_pagar' => Pedido::where('estPed', 'Por pagar')->count(),
            'en_camino' => Pedido::where('estPed', 'En camino')->count(),
            'finalizados' => Pedido::where('estPed', 'Finalizado')->count(),
        ];
    }

    public function create()
    {
        $usuarios = Usuario::where('estadoUsu', 'activo')
            ->where('idRolUsu', 2)
            ->get();

        $productos = Producto::where('canPro', '>', 0)->get();
        // Vista corregida (admin/pedidos/create)
        return view('admin.pedidos.create', compact('usuarios', 'productos'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'idUsuPed' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $usuario = Usuario::where('id', $value)
                        ->where('estadoUsu', 'activo')
                        ->where('idRolUsu', 2)
                        ->first();
                    
                    if (!$usuario) {
                        $fail('El cliente seleccionado no está disponible');
                    }
                }
            ],
            'idProPed' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    if (!Producto::where('idPro', $value)->where('canPro', '>', 0)->exists()) {
                        $fail('El producto seleccionado no tiene inventario disponible');
                    }
                }
            ],
            'fecPed' => 'required|date|after_or_equal:today',
            'prePed' => 'required|numeric|min:1000|max:1000000'
        ], [
            'idUsuPed.required' => 'Debe seleccionar un cliente válido',
            'idProPed.required' => 'Debe seleccionar un producto con stock',
            'prePed.min' => 'El precio mínimo es $1,000',
            'fecPed.after_or_equal' => 'La fecha no puede ser anterior a hoy'
        ]);

        DB::beginTransaction();
        try {
            $pedido = Pedido::create([
                'idUsuPed' => $validatedData['idUsuPed'],
                'idProPed' => $validatedData['idProPed'],
                'fecPed' => Carbon::parse($validatedData['fecPed']),
                'prePed' => $validatedData['prePed'],
                'estPed' => 'Por pagar'
            ]);

            Producto::where('idPro', $validatedData['idProPed'])
                ->decrement('canPro');

            DB::commit();

            return redirect()
                ->route('admin.pedidos.index')
                ->with('success', 'Pedido #'.$pedido->idPed.' creado correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => 'Error al crear pedido: '.$e->getMessage()])
                ->withInput();
        }
    }

    public function edit($id)
    {
        $pedido = Pedido::findOrFail($id);
        $usuarios = Usuario::all();
        $productos = Producto::where('canPro', '>', 0)
            ->orWhere('idPro', $pedido->idProPed)
            ->get();
        // Vista corregida (admin/pedidos/edit)
        return view('admin.pedidos.edit', compact('pedido', 'usuarios', 'productos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'idUsuPed' => 'required|exists:usuarios,idUsu',
            'idProPed' => 'required|exists:productos,idPro',
            'fecPed'   => 'required|date',
            'prePed'   => 'required|numeric|min:0',
        ]);

        $pedido = Pedido::findOrFail($id);
        $pedido->update($request->all());

        return redirect()->route('admin.pedidos.index')->with('success', 'Pedido actualizado correctamente.');
    }

    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();

        return redirect()->route('admin.pedidos.index')->with('success', 'Pedido eliminado correctamente.');
    }

    public function updateEstado(Request $request, $id)
    {
        $request->validate([
            'estPed' => 'required|string|max:100',
        ]);

        $pedido = Pedido::findOrFail($id);
        $pedido->update(['estPed' => $request->estPed]);

        return redirect()->route('admin.pedidos.index')->with('success', 'Estado del pedido actualizado.');
    }

    public function factura($id)
    {
        $pedido = Pedido::with(['detalles.producto', 'usuario'])->findOrFail($id);
        
        // Debug logs para monitorear
        $usuario = auth()->user();
        \Log::info('Factura Debug', [
            'usuario_id' => $usuario->id,
            'usuario_rol' => $usuario->idRolUsu,
            'pedido_id' => $pedido->idPed,
            'pedido_usuario' => $pedido->idUsuPed,
            'request_url' => request()->url(),
            'request_path' => request()->path()
        ]);
        
        // Determinar qué vista usar basado en la URL
        if (request()->is('superadmin/*')) {
            return view('superadmin.pedidos.factura', compact('pedido'));
        } elseif (request()->is('admin/*')) {
            return view('admin.pedidos.factura', compact('pedido'));
        } else {
            return view('clientes.factura', compact('pedido'));
        }
    }

    public function misPedidos(Request $request)
    {
        $userId = auth()->user()->id;
        $query = Pedido::with(['detalles.producto', 'usuario'])->where('idUsuPed', $userId);

        if ($request->filled('estado')) {
            $query->where('estPed', $request->input('estado'));
        }

        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->whereHas('detalles.producto', function ($subQ) use ($buscar) {
                $subQ->where('nomPro', 'like', "%$buscar%");
            })->orWhere('estPed', 'like', "%$buscar%");
        }

        $pedidos = $query->orderBy('fecPed', 'desc')->paginate(10);

        return view('clientes.pedidos.mis-pedidos', [
            'pedidos' => $pedidos
        ]);
    }

    public function pagarPedido($id)
    {
        $pedido = Pedido::with(['detalles.producto', 'usuario'])->findOrFail($id);
        
        // Verificar que el pedido pertenece al usuario autenticado
        if ($pedido->idUsuPed != auth()->user()->id) {
            abort(403, 'No tienes permisos para acceder a este pedido.');
        }
        
        // Verificar que el pedido esté en estado "Por pagar"
        if ($pedido->estPed !== 'Por pagar') {
            return redirect()->route('clientes.pedidos.index')
                ->with('error', 'Este pedido no puede ser pagado en su estado actual.');
        }

        return view('clientes.pedidos.pagar', compact('pedido'));
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class UsuarioController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomUsu' => 'required|string|max:100',
            'apeUsu' => 'required|string|max:70',
            'dirUsu' => 'nullable|string|max:50',
            'telUsu' => 'nullable|string|max:10|regex:/^[0-9]+$/',
            'TipdocUsu' => ['required', Rule::in(['Cedula de Ciudadania', 'Tarjeta de Identidad'])],
            'numdocUsu' => 'nullable|string|max:11|unique:usuarios',
            'emaUsu' => 'required|email|max:100|unique:usuarios,emaUsu',
            'passUsu' => 'required|string|min:8|confirmed',
        ], [
            'passUsu.confirmed' => 'Las contraseñas no coinciden',
            'emaUsu.unique' => 'Este correo ya está registrado',
            'numdocUsu.unique' => 'Este documento ya está registrado',
        ]);

        DB::beginTransaction();

        try {
            $usuario = Usuario::create([
                'nomUsu'     => $request->nomUsu,
                'apeUsu'     => $request->apeUsu,
                'dirUsu'     => $request->dirUsu,
                'telUsu'     => $request->telUsu,
                'TipdocUsu'  => $request->TipdocUsu,
                'numdocUsu'  => $request->numdocUsu,
                'emaUsu'     => $request->emaUsu,
                'passUsu'    => Hash::make($request->passUsu),
                'idRolUsu'   => 2, // Cliente por defecto
                'estadoUsu'  => 'activo',
            ]);

            DB::commit();

            return redirect()->route('login')->with('success', '¡Registro exitoso! Por favor inicia sesión.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors([
                'error' => 'Error al registrar: ' . $e->getMessage()
            ]);
        }
    }

    public function index()
    {
        $usuarios = Usuario::where('idRolUsu', 2)->paginate(10);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function createFromAdmin()
    {
        return view('admin.usuarios.create');
    }

    public function storeFromAdmin(Request $request)
    {
        $request->validate([
            'nomUsu' => 'required|string|max:100',
            'apeUsu' => 'required|string|max:70',
            'dirUsu' => 'nullable|string|max:50',
            'telUsu' => 'nullable|string|max:10|regex:/^[0-9]+$/',
            'TipdocUsu' => ['required', Rule::in(['Cedula de Ciudadania', 'Tarjeta de Identidad'])],
            'numdocUsu' => 'nullable|string|max:11|unique:usuarios',
            'emaUsu' => 'required|email|max:100|unique:usuarios,emaUsu',
            'passUsu' => 'required|string|min:8',
            'idRolUsu' => 'required|integer|in:1,2',
            'estadoUsu' => 'required|string|in:activo,inactivo',
        ]);

        DB::beginTransaction();

        try {
            $usuario = Usuario::create([
                'nomUsu'     => $request->nomUsu,
                'apeUsu'     => $request->apeUsu,
                'dirUsu'     => $request->dirUsu,
                'telUsu'     => $request->telUsu,
                'TipdocUsu'  => $request->TipdocUsu,
                'numdocUsu'  => $request->numdocUsu,
                'emaUsu'     => $request->emaUsu,
                'passUsu'    => Hash::make($request->passUsu),
                'idRolUsu'   => $request->idRolUsu,
                'estadoUsu'  => $request->estadoUsu,
            ]);

            DB::commit();

            return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors([
                'error' => 'Error al crear usuario: ' . $e->getMessage()
            ]);
        }
    }

    public function edit(Usuario $usuario)
    {
        // Verificar que el usuario autenticado sea el propietario del perfil o sea admin
        if (auth()->id() != $usuario->id && (auth()->user()->idRolUsu != 1 && auth()->user()->idRolUsu != 3)) {
            abort(403, 'No tienes permisos para editar este perfil.');
        }
        
        // Si el usuario autenticado es cliente y está editando su propio perfil
        if (auth()->user()->idRolUsu == 2) {
            return view('clientes.profile-edit', compact('usuario'));
        }
        
        // Si es administrador editando cualquier usuario
        return view('admin.usuarios.edit', compact('usuario'));
    }

    // Método específico para administradores editando usuarios
    public function editFromAdmin(Usuario $usuario)
    {
        // Verificar que sea administrador
        if (auth()->user()->idRolUsu != 1 && auth()->user()->idRolUsu != 3) {
            abort(403, 'Solo los administradores pueden acceder a esta función.');
        }
        
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        // Verificar que el usuario autenticado sea el propietario del perfil o sea admin
        if (auth()->id() != $usuario->id && (auth()->user()->idRolUsu != 1 && auth()->user()->idRolUsu != 3)) {
            abort(403, 'No tienes permisos para editar este perfil.');
        }

        // Validación básica para todos los usuarios
        $request->validate([
            'nomUsu' => 'required|string|max:100',
            'apeUsu' => 'required|string|max:70',
            'emaUsu' => 'required|email|unique:usuarios,emaUsu,' . $usuario->id,
            'telUsu' => 'nullable|string|max:10',
            'dirUsu' => 'nullable|string|max:50',
            'TipdocUsu' => 'required|string',
            'numdocUsu' => 'nullable|string|max:11',
        ]);

        // Si es administrador, puede editar todos los campos
        if (auth()->user()->idRolUsu == 1 || auth()->user()->idRolUsu == 3) {
            $request->validate([
                'estadoUsu' => 'required|string',
                'idRolUsu' => 'required|integer',
            ]);
            
            $usuario->update($request->only([
                'nomUsu', 'apeUsu', 'emaUsu', 'telUsu', 'dirUsu', 
                'TipdocUsu', 'numdocUsu', 'estadoUsu', 'idRolUsu'
            ]));
            
            return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
        }
        
        // Si es cliente, solo puede editar sus datos personales
        $usuario->update($request->only([
            'nomUsu', 'apeUsu', 'emaUsu', 'telUsu', 'dirUsu', 
            'TipdocUsu', 'numdocUsu'
        ]));
        
        return redirect()->route('profile')->with('success', 'Perfil actualizado correctamente.');
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Cliente eliminado.');
    }

    public function historial(Usuario $usuario)
    {
        // Verificar que sea administrador
        if (auth()->user()->idRolUsu != 1 && auth()->user()->idRolUsu != 3) {
            abort(403, 'Solo los administradores pueden acceder a esta función.');
        }

        $pedidos = Pedido::where('idUsuPed', $usuario->id)
            ->with('productos')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.usuarios.historial', compact('usuario', 'pedidos'));
    }

    public function buscar(Request $request)
    {
        $query = $request->get('q');
        
        $usuarios = Usuario::where('idRolUsu', 2)
            ->where(function($q) use ($query) {
                $q->where('nomUsu', 'like', "%{$query}%")
                  ->orWhere('apeUsu', 'like', "%{$query}%")
                  ->orWhere('emaUsu', 'like', "%{$query}%")
                  ->orWhere('numdocUsu', 'like', "%{$query}%");
            })
            ->paginate(10);

        return view('admin.usuarios.index', compact('usuarios', 'query'));
    }

    public function misPedidos()
    {
        $pedidos = Pedido::where('idUsuPed', auth()->id())
            ->with('productos')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('clientes.mis-pedidos', compact('pedidos'));
    }

    public function perfil()
    {
        $usuario = auth()->user();
        return view('clientes.profile', compact('usuario'));
    }

    public function editProfile()
    {
        $usuario = auth()->user();
        return view('clientes.profile-edit', compact('usuario'));
    }

    public function updateProfile(Request $request)
    {
        $usuario = auth()->user();

        $request->validate([
            'nomUsu' => 'required|string|max:100',
            'apeUsu' => 'required|string|max:70',
            'emaUsu' => 'required|email|unique:usuarios,emaUsu,' . $usuario->id,
            'telUsu' => 'nullable|string|max:10',
            'dirUsu' => 'nullable|string|max:50',
            'TipdocUsu' => 'required|string',
            'numdocUsu' => 'nullable|string|max:11',
        ]);

        $usuario->update($request->only([
            'nomUsu', 'apeUsu', 'emaUsu', 'telUsu', 'dirUsu', 
            'TipdocUsu', 'numdocUsu'
        ]));

        return redirect()->route('cliente.profile')->with('success', 'Perfil actualizado correctamente.');
    }

    public function pedidoForm()
    {
        $productos = Producto::where('estPro', 'disponible')
            ->where('activo', 1)
            ->get();

        return view('clientes.pedir', compact('productos'));
    }

    public function storePedido(Request $request)
    {
        $request->validate([
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:productos,idPro',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $pedido = Pedido::create([
                'idUsuPed' => auth()->id(),
                'estPed' => 'pendiente',
                'fecPed' => now(),
            ]);

            foreach ($request->productos as $producto) {
                $pedido->productos()->attach($producto['id'], [
                    'canDetPed' => $producto['cantidad']
                ]);
            }

            DB::commit();

            return redirect()->route('mis-pedidos')->with('success', 'Pedido realizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al procesar el pedido: ' . $e->getMessage()]);
        }
    }

    public function factura($id)
    {
        $pedido = Pedido::with(['detalles.producto', 'usuario'])->findOrFail($id);
        
        // Verificar que el usuario autenticado sea el propietario del pedido o sea admin/superadmin
        $usuario = auth()->user();
        $esAdmin = $usuario->idRolUsu == 1 || $usuario->idRolUsu == 3; // Rol 1 = Admin, Rol 3 = Superadmin
        $esPropietario = $pedido->idUsuPed == $usuario->id;
        
        if (!$esPropietario && !$esAdmin) {
            abort(403, 'No tienes permisos para ver esta factura.');
        }

        // Si es administrador, usar vista de admin; si es cliente, usar vista de cliente
        if ($esAdmin) {
            return view('admin.pedidos.factura', compact('pedido'));
        } else {
            return view('clientes.factura', compact('pedido'));
        }
    }
}

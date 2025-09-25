<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Pedido;

// Controlador para manejar pedidos desde el formulario público de clientes
class ClientePedidoController extends Controller
{
    // Mostrar formulario público para que clientes hagan pedidos
    public function formulario()
    {
        $productos = Producto::where('canPro', '>', 0)->get();
        return view('clientes.pedir', compact('productos'));
    }

    // Procesar y guardar pedido desde formulario público
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:200',
            'producto' => 'required|exists:productos,idPro',
        ]);

        // Crear usuario temporal con datos del cliente
        $usuario = Usuario::create([
            'nomUsu' => $request->nombre,
            'apeUsu' => '',
            'telUsu' => $request->telefono,
            'dirUsu' => $request->direccion,
        ]);

        $producto = Producto::findOrFail($request->producto);

        // Crear pedido con precio actual del producto
        Pedido::create([
            'idUsuPed' => $usuario->idUsu,
            'idProPed' => $producto->idPro,
            'fecPed'   => now(),
            'prePed'   => $producto->prePro,
            'estPed'   => 'Por pagar',
        ]);

        // Reducir inventario disponible
        $producto->decrement('canPro');

        return redirect()->back()->with('success', 'Pedido enviado correctamente.');
    }

    // Mostrar pedidos del cliente con filtros por estado
    public function misPedidos(Request $request)
    {
        // Por ahora, simulamos que el cliente tiene ID 1
        // En un sistema real, esto vendría de la sesión o autenticación
        $clienteId = $request->get('cliente_id', 1);
        
        $query = Pedido::with(['usuario', 'producto'])
                      ->where('idUsuPed', $clienteId);

        // Filtrar por estado si se especifica
        if ($request->filled('estado')) {
            $query->where('estPed', $request->get('estado'));
        }

        $pedidos = $query->orderBy('fecPed', 'desc')->get();
        $cliente = Usuario::find($clienteId);

        return view('clientes.mis-pedidos', compact('pedidos', 'cliente'));
    }

    // Mostrar factura desde vista de cliente
    public function factura($id)
    {
        $pedido = Pedido::with(['usuario', 'producto'])->findOrFail($id);
        return view('clientes.factura', compact('pedido'));
    }

    // Buscar cliente (método existente mejorado)
    public function buscar(Request $request)
    {
        $clientes = [];
        
        if ($request->filled('buscar')) {
            $buscar = $request->get('buscar');
            $clientes = Usuario::where('nomUsu', 'like', "%$buscar%")
                             ->orWhere('telUsu', 'like', "%$buscar%")
                             ->get();
        }

        return view('clientes.buscar', compact('clientes'));
    }
}

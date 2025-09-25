<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Session;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = Session::get('carrito', []);
        $productos = [];
        $total = 0;

        foreach ($carrito as $id => $cantidad) {
            $producto = Producto::find($id);
            if ($producto && $producto->estPro == 'Activo' && $producto->canPro > 0) {
                $productos[] = [
                    'producto' => $producto,
                    'cantidad' => $cantidad,
                    'subtotal' => $producto->precio_venta * $cantidad
                ];
                $total += $producto->precio_venta * $cantidad;
            } else {
                // Remover productos no disponibles del carrito
                unset($carrito[$id]);
            }
        }

        // Actualizar carrito sin productos no disponibles
        Session::put('carrito', $carrito);

        return view('clientes.carrito.index', compact('productos', 'total'));
    }

    public function agregar(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,idPro',
            'cantidad' => 'required|integer|min:1'
        ]);

        $producto = Producto::findOrFail($request->producto_id);
        
        // Verificar disponibilidad
        if ($producto->estPro !== 'Activo' || $producto->canPro < $request->cantidad) {
            return back()->with('error', 'Producto no disponible en la cantidad solicitada.');
        }

        $carrito = Session::get('carrito', []);
        $id = $request->producto_id;

        if (isset($carrito[$id])) {
            $carrito[$id] += $request->cantidad;
        } else {
            $carrito[$id] = $request->cantidad;
        }

        // Verificar que no exceda el stock disponible
        if ($carrito[$id] > $producto->canPro) {
            return back()->with('error', 'No hay suficiente stock disponible.');
        }

        Session::put('carrito', $carrito);

        return back()->with('success', 'Producto agregado al carrito correctamente.');
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,idPro',
            'cantidad' => 'required|integer|min:0'
        ]);

        $carrito = Session::get('carrito', []);
        $id = $request->producto_id;

        if ($request->cantidad == 0) {
            unset($carrito[$id]);
        } else {
            $producto = Producto::findOrFail($id);
            
            if ($producto->estPro !== 'Activo' || $producto->canPro < $request->cantidad) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay suficiente stock disponible.'
                ]);
            }
            
            $carrito[$id] = $request->cantidad;
        }

        Session::put('carrito', $carrito);

        return response()->json([
            'success' => true,
            'message' => 'Carrito actualizado correctamente.'
        ]);
    }

    public function eliminar($id)
    {
        $carrito = Session::get('carrito', []);
        
        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            Session::put('carrito', $carrito);
        }

        return back()->with('success', 'Producto eliminado del carrito.');
    }

    public function limpiar()
    {
        Session::forget('carrito');
        return back()->with('success', 'Carrito limpiado correctamente.');
    }

    public function checkout()
    {
        $carrito = Session::get('carrito', []);
        
        if (empty($carrito)) {
            return redirect()->route('clientes.carrito.index')->with('error', 'El carrito está vacío.');
        }

        $productos = [];
        $total = 0;

        foreach ($carrito as $id => $cantidad) {
            $producto = Producto::find($id);
            if ($producto && $producto->estPro == 'Activo' && $producto->canPro >= $cantidad) {
                $productos[] = [
                    'producto' => $producto,
                    'cantidad' => $cantidad,
                    'subtotal' => $producto->precio_venta * $cantidad
                ];
                $total += $producto->precio_venta * $cantidad;
            } else {
                return redirect()->route('clientes.carrito.index')->with('error', 'Algunos productos no están disponibles.');
            }
        }

        return view('clientes.carrito.checkout', compact('productos', 'total'));
    }

        public function procesarPedido(Request $request)
    {
        $request->validate([
            'metodo_pago' => 'required|in:PayU',
            'direccion_entrega' => 'required|string|max:255',
            'notas' => 'nullable|string|max:500'
        ]);

        $carrito = Session::get('carrito', []);
        
        if (empty($carrito)) {
            return redirect()->route('clientes.carrito.index')->with('error', 'El carrito está vacío.');
        }

        try {
            \DB::beginTransaction();

            // Calcular total
            $total = 0;
            foreach ($carrito as $productoId => $cantidad) {
                $producto = \App\Models\Producto::findOrFail($productoId);
                $total += $producto->precio_venta * $cantidad;
            }

            // Crear el pedido
            $pedido = \App\Models\Pedido::create([
                'idUsuPed' => auth()->user()->id,     
                'fecPed' => now(),
                'estPed' => 'Por pagar',
                'prePed' => $total
            ]);

            // Agregar productos al pedido
            foreach ($carrito as $productoId => $cantidad) {
                $producto = Producto::findOrFail($productoId);

                \App\Models\Detallesped::create([
                    'idPedDet' => $pedido->idPed,
                    'idProDet' => $productoId,
                    'canDet' => $cantidad,
                    'preProDet' => $producto->precio_venta
                ]);

                // Actualizar stock
                $producto->decrement('canPro', $cantidad);
            }

            \DB::commit();

            // Limpiar carrito
            Session::forget('carrito');

            return redirect()->route('clientes.pedidos.index')
                ->with('success', 'Pedido realizado correctamente. Número de pedido: #' . $pedido->idPed);

        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Error al procesar el pedido: ' . $e->getMessage());
        }
    }

    public function obtenerCantidad()
    {
        $carrito = Session::get('carrito', []);
        return response()->json(['cantidad' => array_sum($carrito)]);
    }
} 
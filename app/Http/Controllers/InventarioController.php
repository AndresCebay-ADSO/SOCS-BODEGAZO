<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::with('producto.categoria')->paginate(10);
        return view('admin.inventarios.index', compact('inventarios'));
    }

    public function create()
    {
        $categorias = Categoria::with(['productos' => function($query) {
            $query->where('estPro', 'Activo')
                  ->where('activo', true);
        }])->where('estCat', 'Activo')->get();

        return view('admin.inventarios.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'idProInv' => 'required|exists:productos,idPro',
            'canInv' => 'required|integer|min:1'
        ]);

        try {
            \DB::beginTransaction();

            // Creación segura del inventario
            $inventario = new Inventario();
            $inventario->idProInv = $validated['idProInv'];
            $inventario->canInv = $validated['canInv'];
            $inventario->ultactInv = now()->format('Y-m-d H:i:s'); // Formato MySQL explícito
            $inventario->save();

            // Actualización concurrente segura del stock
            Producto::where('idPro', $validated['idProInv'])
                ->increment('canPro', $validated['canInv']);

            \DB::commit();

            return redirect()->route('inventarios.index')
                            ->with('success', 'Inventario registrado correctamente');

        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Error al registrar: ' . $e->getMessage());
        }
    }

    public function show(Inventario $inventario)
    {
        return view('admin.inventarios.show', compact('inventario'));
    }

    public function edit(Inventario $inventario)
    {
        // Obtener todos los productos activos con los campos necesarios
        $productos = Producto::where('estPro', 'Activo')
                            ->where('activo', true)
                            ->get(['idPro as id', 'nomPro as nombre', 'codPro as codigo']);
        
        return view('admin.inventarios.edit', [
            'inventario' => $inventario,
            'productos' => $productos
        ]);
    }

        public function update(Request $request, Inventario $inventario)
    {
        $validated = $request->validate([
            'idProInv' => 'required|exists:productos,idPro',
            'canInv' => 'required|integer|min:0|max:999999'
        ]);

        \DB::transaction(function () use ($validated, $inventario) {
            // Solo actualizar stock si hubo cambios relevantes
            if ($inventario->idProInv != $validated['idProInv'] || $inventario->canInv != $validated['canInv']) {
                // Revertir stock anterior
                Producto::where('idPro', $inventario->idProInv)
                    ->decrement('canPro', $inventario->canInv);
                
                // Aplicar nuevo stock
                Producto::where('idPro', $validated['idProInv'])
                    ->increment('canPro', $validated['canInv']);
            }

            // Actualizar registro de inventario
            $inventario->update([
                'idProInv' => $validated['idProInv'],
                'canInv' => $validated['canInv'],
                'ultactInv' => now()
            ]);
        });

        return redirect()->route('inventarios.index')
                        ->with('success', 'Inventario actualizado correctamente');
    }

    public function destroy(Inventario $inventario)
    {
        // Revertir stock antes de eliminar
        $producto = Producto::find($inventario->idProInv);
        $producto->canPro -= $inventario->canInv;
        $producto->save();

        $inventario->delete();

        return redirect()->route('inventarios.index')
                         ->with('success', 'Registro eliminado y stock ajustado');
    }
}
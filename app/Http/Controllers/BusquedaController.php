<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;

class BusquedaController extends Controller
{
    public function buscar(Request $request)
    {
        $query = $request->get('q', '');
        
        if (empty($query)) {
            return redirect()->route('clientes.productos.index');
        }

        $productos = Producto::where('estPro', 'Activo')
            ->where(function($q) use ($query) {
                $q->where('nomPro', 'LIKE', "%{$query}%")
                  ->orWhere('marPro', 'LIKE', "%{$query}%")
                  ->orWhere('colPro', 'LIKE', "%{$query}%")
                  ->orWhere('tallPro', 'LIKE', "%{$query}%")
                  ->orWhereHas('categoria', function($cat) use ($query) {
                      $cat->where('nomCat', 'LIKE', "%{$query}%");
                  });
            })
            ->with('categoria')
            ->paginate(12);

        return view('clientes.busqueda.resultados', compact('productos', 'query'));
    }

    public function autocompletar(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $sugerencias = [];

        // Buscar productos
        $productos = Producto::where('estPro', 'Activo')
            ->where(function($q) use ($query) {
                $q->where('nomPro', 'LIKE', "%{$query}%")
                  ->orWhere('marPro', 'LIKE', "%{$query}%");
            })
            ->limit(5)
            ->get();

        foreach ($productos as $producto) {
            $sugerencias[] = [
                'tipo' => 'producto',
                'id' => $producto->idPro,
                'texto' => $producto->nomPro,
                'subtitulo' => $producto->marPro,
                'precio' => $producto->precio_venta,
                'imagen' => $producto->imagen_url,
                'url' => route('clientes.productos.show', $producto->idPro)
            ];
        }

        // Buscar categorías
        $categorias = Categoria::where('nomCat', 'LIKE', "%{$query}%")
            ->limit(3)
            ->get();

        foreach ($categorias as $categoria) {
            $sugerencias[] = [
                'tipo' => 'categoria',
                'id' => $categoria->idCat,
                'texto' => $categoria->nomCat,
                'subtitulo' => 'Categoría',
                'url' => route('clientes.productos.categoria', $categoria->idCat)
            ];
        }

        return response()->json($sugerencias);
    }
} 
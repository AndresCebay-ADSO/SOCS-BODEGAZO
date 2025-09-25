<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ClienteProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('categoria')
            ->where('activo', 1)
            ->whereIn('estPro', ['Activo', 'disponible'])
            ->when(request('search'), function($query) {
                return $query->where('nomPro', 'like', '%'.request('search').'%')
                            ->orWhere('marPro', 'like', '%'.request('search').'%')
                            ->orWhere('codPro', 'like', '%'.request('search').'%');
            })
            ->when(request('categoria'), function($query) {
                return $query->where('idcatPro', request('categoria'));
            })
            ->orderBy('nomPro', 'asc')
            ->paginate(12);

        $categorias = Categoria::where('estCat', 'Activo')->get();

        return view('clientes.productos.index', compact('productos', 'categorias'));
    }

    public function show(Producto $producto)
    {
        if (!$producto->activo || !in_array($producto->estPro, ['Activo', 'disponible'])) {
            abort(404, 'Producto no disponible');
        }

        $producto->load('categoria');
        
        // Productos relacionados de la misma categoría
        $productosRelacionados = Producto::with('categoria')
            ->where('idcatPro', $producto->idcatPro)
            ->where('idPro', '!=', $producto->idPro)
            ->where('activo', 1)
            ->whereIn('estPro', ['Activo', 'disponible'])
            ->limit(4)
            ->get();

        return view('clientes.productos.show', compact('producto', 'productosRelacionados'));
    }

    public function categoria($categoriaId)
    {
        $categoria = Categoria::findOrFail($categoriaId);
        
        $productos = Producto::with('categoria')
            ->where('idcatPro', $categoriaId)
            ->where('activo', 1)
            ->whereIn('estPro', ['Activo', 'disponible'])
            ->orderBy('nomPro', 'asc')
            ->paginate(12);

        return view('clientes.productos.categoria', compact('productos', 'categoria'));
    }

    public function categorias()
    {
        $productos = Producto::with('categoria')
            ->where('activo', 1)
            ->whereIn('estPro', ['Activo', 'disponible'])
            ->orderBy('nomPro', 'asc')
            ->get();

        $categorias = Categoria::where('estCat', 'Activo')->get();

        return view('clientes.categorias', compact('productos', 'categorias'));
    }
} 
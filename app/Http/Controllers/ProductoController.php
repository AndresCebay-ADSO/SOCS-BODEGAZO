<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('categoria')
            ->when(request('search'), function($query) {
                return $query->where('nomPro', 'like', '%'.request('search').'%')
                            ->orWhere('codPro', 'like', '%'.request('search').'%');
            })
            ->when(request('categoria'), function($query) {
                return $query->where('idcatPro', request('categoria'));
            })
            ->when(request('estado'), function($query) {
                return $query->where('estPro', request('estado'));
            })
            ->orderBy('nomPro', 'asc')
            ->paginate(10);

        $categorias = Categoria::where('estCat', 'Activo')->get();

        return view('admin.productos.index', compact('productos', 'categorias'));
    }

    public function create()
    {
        $categorias = Categoria::where('estCat', 'Activo')->get();
        return view('admin.productos.create', compact('categorias'));
    }


    public function store(Request $request)
    {
        try {
            // Mostrar todos los datos que llegan del form
            \Log::info('Request recibido:', $request->all());

            // Validar manualmente y mostrar errores si hay
            $validated = $this->validateProducto($request);
            \Log::info('Datos validados:', $validated);

            $validated['activo'] = $request->has('activo') ? 1 : 0;

            if ($request->hasFile('imagen')) {
                $validated['imagen'] = $this->guardarImagen($request->file('imagen'));
            }

            Producto::create($validated);

            return redirect()->route('admin.productos.index')
                            ->with('success', 'Producto creado correctamente');

        } catch(\Exception $e) {
            \Log::error('Error al crear producto: ' . $e->getMessage());
            return back()->with('error', 'Error al crear el producto: ' . $e->getMessage())
                        ->withInput();
        }
    }


    public function show(Producto $producto)
    {
        $producto->load('categoria', 'inventarios');
        return view('admin.productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::where('estCat', 'Activo')->get();
        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        try {
            $validated = $this->validateProducto($request, $producto);
            $validated['activo'] = $request->has('activo') ? 1 : 0;

            if($request->hasFile('imagen')) {
                // Eliminar imagen anterior si existe
                if ($producto->imagen) {
                    Storage::disk('public')->delete('productos/'.$producto->imagen);
                }
                $validated['imagen'] = $this->guardarImagen($request->file('imagen'));
            }
            
            $producto->update($validated);
            
            return redirect()->route('admin.productos.index')
                            ->with('success', 'Producto actualizado correctamente');

        } catch(\Exception $e) {
            return back()->with('error', 'Error al actualizar el producto: ' . $e->getMessage())
                        ->withInput();
        }
    }

    public function destroy(Producto $producto)
    {
        try {
            if ($producto->inventarios()->exists()) {
                return back()->with('error', 'No se puede eliminar el producto porque tiene registros de inventario asociados');
            }
            if ($producto->imagen) {
                Storage::disk('public')->delete('productos/'.$producto->imagen);
            }
            $producto->delete();
            
            return redirect()->route('admin.productos.index')
                           ->with('success', 'Producto eliminado exitosamente');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }

    protected function validateProducto(Request $request, Producto $producto = null)
    {
        $rules = [
            'nomPro' => 'required|string|max:255',
            'marPro' => 'nullable|string|max:50',
            'codPro' => 'required|string|max:20|unique:productos,codPro',
            'colPro' => 'nullable|string|max:30',
            'tallPro' => 'nullable|string|max:10',
            'idcatPro' => 'required|exists:categorias,idCat',
            'estPro' => 'required|string|in:Activo,Inactivo,Agotado',
            'unidad_medida' => 'required|string|in:UND,KG,LT,MTS',
            'precio_compra' => 'nullable|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'activo' => 'sometimes|boolean',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];
        if ($producto) {
            $rules['codPro'] = 'required|string|max:20|unique:productos,codPro,'.$producto->idPro.',idPro';
        }
        return $request->validate($rules);
    }

    protected function guardarImagen($imagen)
    {
        try{
            $storagePath = storage_path('app/public/productos');
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }
            $imagenName = 'prod_'.time().'_'.Str::random(8).'.'.$imagen->getClientOriginalExtension();
            $img = Image::make($imagen->getRealPath())
                ->resize(800, 800, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            // Guardar imagen en el directorio
            $img->save($storagePath.'/'.$imagenName, 85);
            return $imagenName;
        }catch(\Exception $e) {
            \Log::error('Error al guardar la imagen: ' . $e->getMessage());
            throw new \Exception('Error al procesar la imagen: ' . $e->getMessage());
        }
    }

    public function superAdminIndex()
    {
        return view('superadmin.extended.productos.index', [
            'productos' => Producto::withTrashed()
                                ->with(['categoria', 'inventarios'])
                                ->get(),
            'allCategories' => Categoria::all(),
            'canManage' => true
        ]);
    }

    public function bulkUpdate(Request $request)
    {
        // Lógica para actualización masiva
    }
}
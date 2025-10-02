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
        $productosQuery = Producto::with('categoria', 'inventarios')
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
            ->orderBy('nomPro', 'asc');

        $productos = $productosQuery->paginate(10);

        // Calcular el stock total para cada producto
        $productos->getCollection()->transform(function ($producto) {
            $producto->stock_total = $producto->inventarios->sum('canInv');
            return $producto;
        });

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
        $producto->load('categoria', 'inventarios.usuario');

        // Calcular el stock total sumando los movimientos de inventario
        $stock_total = $producto->inventarios->sum('canInv');

        return view('admin.productos.show', compact('producto', 'stock_total'));
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::where('estCat', 'Activo')->get();
        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        // Log de depuración para ver todos los datos de la solicitud
        \Log::info('Inicio de la actualización del producto ID: ' . $producto->id);
        \Log::info('Datos del request:', $request->all());
        \Log::info('Archivos en el request:', $request->allFiles());
    
        try {
            \DB::beginTransaction();
            
            \Log::info('Actualizando producto ID: ' . $producto->idPro);
            \Log::info('Datos recibidos:', $request->all());

            // 1. Validar todos los datos de entrada
            $validated = $this->validateProducto($request, $producto);
            \Log::info('Datos validados:', $validated);
            
            // 2. Preparar el array de datos para la actualización, excluyendo la imagen por ahora
            $dataToUpdate = $validated;
            unset($dataToUpdate['imagen']);

            // 3. A��adir el estado 'activo'
            $dataToUpdate['activo'] = $request->has('activo') ? 1 : 0;
            \Log::info('Estado activo:', ['activo' => $dataToUpdate['activo']]);

            // 4. Manejar la carga de la imagen si se subió una nueva
            if ($request->hasFile('imagen')) {
                \Log::info('Procesando nueva imagen');
                try {
                    // Eliminar imagen anterior de forma segura
                    if ($producto->imagen) {
                        \Log::info('Eliminando imagen anterior: ' . $producto->imagen);
                        \Storage::disk('public')->delete('productos/' . $producto->imagen);
                    }

                    // Guardar la nueva imagen y añadir su nombre a los datos para actualizar
                    $dataToUpdate['imagen'] = $this->guardarImagen($request->file('imagen'));
                    \Log::info('Nueva imagen guardada:', ['imagen' => $dataToUpdate['imagen']]);

                } catch (\Exception $e) {
                    \Log::error('Error procesando imagen: ' . $e->getMessage());
                    throw new \Exception('Error al procesar la imagen: ' . $e->getMessage());
                }
            }
            
            \Log::info('Datos finales a actualizar:', $dataToUpdate);
            
            // 5. Actualizar el producto en la base de datos
            $resultado = $producto->update($dataToUpdate);
            \Log::info('Resultado de la actualización:', ['success' => $resultado]);
            
            if (!$resultado) {
                throw new \Exception('No se pudo actualizar el producto.');
            }
            
            \DB::commit();
            
            return redirect()->route('admin.productos.index')
                            ->with('success', 'Producto actualizado correctamente');
                            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \DB::rollBack();
            \Log::error('Error de validación: ' . json_encode($e->errors()));
            return back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error actualizando producto: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el producto: ' . $e->getMessage());
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
            'estPro' => 'required|string|in:Activo,Inactivo',
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
        try {
            \Log::info('Iniciando proceso de guardar imagen');
            
            // Asegurarse que el directorio existe
            $storagePath = storage_path('app/public/productos');
            if (!file_exists($storagePath)) {
                \Log::info('Creando directorio de productos');
                mkdir($storagePath, 0755, true);
            }
            
            // Generar nombre único para la imagen
            $extension = $imagen->getClientOriginalExtension();
            $imagenName = 'prod_'.time().'_'.Str::random(8).'.'.$extension;
            \Log::info('Nombre de imagen generado: ' . $imagenName);
            
            // Mover el archivo directamente
            $imagen->move($storagePath, $imagenName);
            \Log::info('Imagen movida correctamente');
            
            $rutaCompleta = $storagePath.'/'.$imagenName;
            
            // Verificar que el archivo existe y procesar con Intervention Image
            if (file_exists($rutaCompleta)) {
                \Log::info('Archivo guardado, procesando con Intervention Image');
                
                $img = Image::make($rutaCompleta);
                $img->resize(800, 800, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->save($rutaCompleta, 85);
                
                \Log::info('Imagen procesada y guardada correctamente');
            } else {
                throw new \Exception('El archivo no se guardó correctamente');
            }
            
            return $imagenName;
        } catch(\Exception $e) {
            \Log::error('Error al guardar la imagen: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Si el archivo se creó pero hubo un error al procesarlo, intentar eliminarlo
            $rutaCompleta = $storagePath.'/'.$imagenName ?? '';
            if (file_exists($rutaCompleta)) {
                unlink($rutaCompleta);
                \Log::info('Archivo temporal eliminado después del error');
            }
            
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
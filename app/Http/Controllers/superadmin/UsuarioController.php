<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Pedido;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    /**
     * Mostrar listado de usuarios
     */
    public function index(Request $request)
    {
        $query = Usuario::with('rol');

        // Búsqueda por texto
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function($q) use ($search) {
                $q->where('nomUsu', 'like', "%{$search}%")
                  ->orWhere('apeUsu', 'like', "%{$search}%")
                  ->orWhere('emaUsu', 'like', "%{$search}%")
                  ->orWhere('numdocUsu', 'like', "%{$search}%");
            });
        }
        
        // Filtro por rol
        if ($request->filled('rol')) {
            $query->where('idRolUsu', $request->input('rol'));
        }
        
        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estadoUsu', $request->input('estado'));
        }
        
        $usuarios = $query->paginate(10);
        
        return view('superadmin.usuarios.index', [
            'usuarios' => $usuarios,
            'roles' => Rol::all() // Para los filtros en la vista
        ]);
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('superadmin.usuarios.create', [
            'roles' => Rol::all()
        ]);
    }

    /**
     * Almacenar nuevo usuario
     */
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
            'passUsu' => 'required|string|min:8',
            'idRolUsu' => 'required|integer|exists:roles,idRol', // Cambiado a idRol
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
                'passUsu'    => bcrypt($request->passUsu),
                'idRolUsu'   => $request->idRolUsu,
                'estadoUsu'  => $request->estadoUsu,
            ]);

            DB::commit();

            return redirect()->route('superadmin.usuarios.index')
                ->with('success', 'Usuario creado correctamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->withErrors(['error' => 'Error al crear usuario: ' . $e->getMessage()]);
        }
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('superadmin.usuarios.edit', compact('usuario'));
    }

    /**
     * Actualizar usuario
     */
    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'nomUsu' => 'required|string|max:100',
            'apeUsu' => 'required|string|max:70',
            'emaUsu' => 'required|email|unique:usuarios,emaUsu,' . $usuario->id,
            'telUsu' => 'nullable|string|max:10',
            'dirUsu' => 'nullable|string|max:50',
            'TipdocUsu' => 'required|string',
            'numdocUsu' => 'nullable|string|max:11|unique:usuarios,numdocUsu,' . $usuario->id,
            'idRolUsu' => 'required|integer|exists:roles,idRol', // Cambiado a idRol
            'estadoUsu' => 'required|string|in:activo,inactivo',
        ]);

        $data = $request->only([
            'nomUsu', 'apeUsu', 'emaUsu', 'telUsu', 'dirUsu',
            'TipdocUsu', 'numdocUsu', 'idRolUsu', 'estadoUsu'
        ]);

        // Actualizar contraseña solo si se proporcionó
        if ($request->filled('passUsu')) {
            $data['passUsu'] = bcrypt($request->passUsu);
        }

        $usuario->update($data);

        return redirect()->route('superadmin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar usuario
     */
    public function destroy(Usuario $usuario)
    {
        DB::beginTransaction();

        try {
            $usuario->delete();
            DB::commit();
            
            return redirect()->route('superadmin.usuarios.index')
                ->with('success', 'Usuario eliminado correctamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al eliminar usuario: ' . $e->getMessage()]);
        }
    }

    /**
     * Mostrar historial de pedidos del usuario
     */
    public function historial(Usuario $usuario)
    {
        $pedidos = Pedido::where('idUsuPed', $usuario->id)
            ->with('productos')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('superadmin.usuarios.historial', compact('usuario', 'pedidos'));
    }
}
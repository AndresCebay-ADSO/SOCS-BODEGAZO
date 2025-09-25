<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Permission;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminManagementController extends Controller
{
    public function index()
    {
        $administradores = Usuario::where('idRolUsu', 1)
            ->with('permissions')
            ->paginate(10);
            
        return view('superadmin.management.index', compact('administradores'));
    }

    public function create()
    {
        $permissions = Permission::getByModule();
        return view('superadmin.management.create', compact('permissions'));
        return view('superadmin.management.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomUsu' => 'required|string|max:100',
            'apeUsu' => 'required|string|max:70',
            'emaUsu' => 'required|email|max:100|unique:usuarios,emaUsu',
            'telUsu' => 'nullable|string|max:10|regex:/^[0-9]+$/',
            'dirUsu' => 'nullable|string|max:50',
            'TipdocUsu' => ['required', Rule::in(['Cedula de Ciudadania', 'Tarjeta de Identidad'])],
            'numdocUsu' => 'nullable|string|max:11|unique:usuarios',
            'passUsu' => 'required|string|min:8|confirmed',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ], [
            'passUsu.confirmed' => 'Las contraseñas no coinciden',
            'emaUsu.unique' => 'Este correo ya está registrado',
            'numdocUsu.unique' => 'Este documento ya está registrado',
        ]);

        DB::beginTransaction();

        try {
            // Crear el administrador
            $admin = Usuario::create([
                'nomUsu' => $request->nomUsu,
                'apeUsu' => $request->apeUsu,
                'emaUsu' => $request->emaUsu,
                'telUsu' => $request->telUsu,
                'dirUsu' => $request->dirUsu,
                'TipdocUsu' => $request->TipdocUsu,
                'numdocUsu' => $request->numdocUsu,
                'passUsu' => Hash::make($request->passUsu),
                'idRolUsu' => 1, // Forzar rol de administrador
                'estadoUsu' => 'activo',
            ]);

            // Asignar permisos
            if ($request->has('permissions')) {
                $admin->permissions()->sync($request->permissions);
            }

            DB::commit();

            return redirect()->route('superadmin.management.index')
                ->with('success', 'Administrador creado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors([
                'error' => 'Error al crear administrador: ' . $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        $admin = Usuario::where('idRolUsu', 1)->findOrFail($id);
        $permissions = Permission::getByModule();
        $adminPermissions = $admin->permissions->pluck('id')->toArray();
        
        return view('superadmin.management.edit', compact('admin', 'permissions', 'adminPermissions'));
    }

    public function update(Request $request, $id)
    {
        $admin = Usuario::where('idRolUsu', 1)->findOrFail($id);
        
        $request->validate([
            'nomUsu' => 'required|string|max:100',
            'apeUsu' => 'required|string|max:70',
            'emaUsu' => 'required|email|max:100|unique:usuarios,emaUsu,' . $admin->id,
            'telUsu' => 'nullable|string|max:10|regex:/^[0-9]+$/',
            'dirUsu' => 'nullable|string|max:50',
            'TipdocUsu' => ['required', Rule::in(['Cedula de Ciudadania', 'Tarjeta de Identidad'])],
            'numdocUsu' => 'nullable|string|max:11|unique:usuarios,numdocUsu,' . $admin->id,
            'estadoUsu' => 'required|string|in:activo,inactivo',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        DB::beginTransaction();

        try {
            // Actualizar datos del administrador
            $admin->update([
                'nomUsu' => $request->nomUsu,
                'apeUsu' => $request->apeUsu,
                'emaUsu' => $request->emaUsu,
                'telUsu' => $request->telUsu,
                'dirUsu' => $request->dirUsu,
                'TipdocUsu' => $request->TipdocUsu,
                'numdocUsu' => $request->numdocUsu,
                'estadoUsu' => $request->estadoUsu,
            ]);

            // Actualizar contraseña si se proporciona
            if ($request->filled('passUsu')) {
                $request->validate([
                    'passUsu' => 'required|string|min:8|confirmed'
                ], [
                    'passUsu.confirmed' => 'Las contraseñas no coinciden'
                ]);
                
                $admin->update([
                    'passUsu' => Hash::make($request->passUsu)
                ]);
            }

            // Actualizar permisos
            if ($request->has('permissions')) {
                $admin->permissions()->sync($request->permissions);
            } else {
                $admin->permissions()->detach();
            }

            DB::commit();

            return redirect()->route('superadmin.management.index')
                ->with('success', 'Administrador actualizado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors([
                'error' => 'Error al actualizar administrador: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        $admin = Usuario::where('idRolUsu', 1)->findOrFail($id);
        
        // Verificar que no sea el último administrador
        $adminCount = Usuario::where('idRolUsu', 1)->count();
        if ($adminCount <= 1) {
            return back()->withErrors([
                'error' => 'No se puede eliminar el último administrador del sistema.'
            ]);
        }

        DB::beginTransaction();

        try {
            // Eliminar permisos asociados
            $admin->permissions()->detach();
            
            // Eliminar el administrador
            $admin->delete();

            DB::commit();

            return redirect()->route('superadmin.management.index')
                ->with('success', 'Administrador eliminado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Error al eliminar administrador: ' . $e->getMessage()
            ]);
        }
    }

    public function adminsStoreStep1(Request $request)
    {
        $validated = $request->validate([
            'nomUsu' => ['required', 'string', 'max:255'],
            'apeUsu' => ['required', 'string', 'max:255'],
            'emaUsu' => ['required', 'string', 'email', 'max:255', 'unique:usuarios'],
            'telUsu' => ['nullable', 'string', 'max:20'],
            'idRolUsu' => ['required', 'exists:roles,idRol'],
            'estadoUsu' => ['required', 'in:activo,inactivo'],
            'passUsu' => ['required', Password::defaults()],
        ]);

        $admin = Usuario::create([
            'nomUsu' => $validated['nomUsu'],
            'apeUsu' => $validated['apeUsu'],
            'emaUsu' => $validated['emaUsu'],
            'telUsu' => $validated['telUsu'],
            'idRolUsu' => $validated['idRolUsu'],
            'estadoUsu' => $validated['estadoUsu'],
            'passUsu' => Hash::make($validated['passUsu']),
        ]);

        return response()->json([
            'message' => 'Administrador creado exitosamente',
            'admin' => $admin
        ], 201);
    }
}
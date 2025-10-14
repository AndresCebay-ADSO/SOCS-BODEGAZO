<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;

class NotificacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las notificaciones, las más recientes primero, y paginarlas.
        $notificaciones = Notificacion::latest()->paginate(15);

        // Determinar la vista correcta según el rol del usuario (admin o superadmin)
        $view = request()->is('superadmin/*') 
            ? 'superadmin.notificaciones.index' 
            : 'admin.notificaciones.index';

        return view($view, compact('notificaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createAdmin()
    {
        return view('admin.notificaciones.create', [
            'usuarios' => Usuario::where('estadoUsu', 'Activo')->orderBy('nomUsu')->get(['id', 'nomUsu', 'apeUsu', 'emaUsu'])
        ]);
    }

    /**
     * Almacenar nueva notificación (Admin).
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'idUsuNot' => 'required',
            'menNot' => 'required|string|max:255',
        ]);

        $idUsuNot = $request->input('idUsuNot');
        $menNot = $request->input('menNot');
        $fechNot = now();

        if ($idUsuNot === 'all') {
            $rolCliente = Rol::where('tipRol', 'cliente')->first();
            if ($rolCliente) {
                $clientes = Usuario::where('idRolUsu', $rolCliente->idRol)->get();
                foreach ($clientes as $cliente) {
                    Notificacion::create([
                        'idUsuNot' => $cliente->id,
                        'menNot' => $menNot,
                        'fechNot' => $fechNot,
                        'estNot' => 'Activo',
                    ]);
                }
                $message = 'Notificaciones masivas enviadas con éxito.';
            } else {
                return redirect()->back()->with('error', 'Error: No se pudo encontrar el rol de cliente.');
            }
        } else {
            Notificacion::create([
                'idUsuNot' => $idUsuNot,
                'menNot' => $menNot,
                'fechNot' => $fechNot,
                'estNot' => 'Activo',
            ]);
            $message = 'Notificación enviada con éxito.';
        }

        return redirect()->route('admin.notificaciones.create')->with('success', $message);
    }
    
    /**
     * Muestra el formulario para editar una notificación existente (Admin).
     */
    public function editAdmin($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $usuarios = Usuario::where('estadoUsu', 'Activo')->orderBy('nomUsu')->get(['id', 'nomUsu', 'apeUsu', 'emaUsu']);
        
        return view('admin.notificaciones.edit', compact('notificacion', 'usuarios'));
    }

    /**
     * Actualiza una notificación existente en la base de datos (Admin).
     */
    public function updateAdmin(Request $request, $id)
    {
        $request->validate([
            'idUsuNot' => 'required|exists:usuarios,id',
            'menNot' => 'required|string|max:255',
            'estNot' => 'required|in:Activo,Inactivo',
        ]);

        $notificacion = Notificacion::findOrFail($id);
        $notificacion->update($request->all());

        return redirect()->route('admin.notificaciones.index')->with('success', 'Notificación actualizada con éxito.');
    }

    /**
     * Eliminar notificación (Admin).
     */
    public function destroyAdmin($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->delete();

        return redirect()->route('admin.notificaciones.index')->with('success', 'Notificación eliminada exitosamente.');
    }
}
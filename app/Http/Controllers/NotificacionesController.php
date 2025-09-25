<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\Usuario;
use Illuminate\Http\Request;

class NotificacionesController extends Controller
{
    /**
     * Mostrar listado de notificaciones
     */
    public function index(Request $request)
    {
        $query = Notificacion::with('usuario')
                ->orderBy('fechNot', 'desc');

        // Búsqueda por mensaje o destinatario
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('menNot', 'like', '%'.$searchTerm.'%')
                ->orWhereHas('usuario', function($q) use ($searchTerm) {
                    $q->where('nomUsu', 'like', '%'.$searchTerm.'%')
                        ->orWhere('apeUsu', 'like', '%'.$searchTerm.'%')
                        ->orWhere('emaUsu', 'like', '%'.$searchTerm.'%');
                });
            });
        }

        // Filtro por estado si está presente
        if ($request->has('estado')) {
            $query->where('estNot', $request->estado);
        }

        $notificaciones = $query->paginate(10);

        return view('admin.notificaciones.index', compact('notificaciones'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('admin.notificaciones.create', [
            'usuarios' => Usuario::where('estadoUsu', 'Activo')
                            ->orderBy('nomUsu')
                            ->get(['id', 'nomUsu', 'apeUsu', 'emaUsu'])
        ]);
    }

    /**
     * Almacenar nueva notificación
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idUsuNot' => 'required|exists:usuarios,id',
            'menNot' => 'required|string|max:255',
            'fechNot' => 'required|date',
            'estNot' => 'required|in:Activo,Inactivo'
        ]);

        Notificacion::create($validated);

        return redirect()
            ->route('notificaciones.index')
            ->with('success', 'Notificación creada correctamente');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $usuarios = Usuario::where('estadoUsu', 'Activo')
                        ->orderBy('nomUsu')
                        ->get(['id', 'nomUsu', 'apeUsu', 'emaUsu']);
                        
        return view('admin.notificaciones.edit', compact('notificacion', 'usuarios'));
    }

    /**
     * Actualizar notificación existente
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'idUsuNot' => 'required|exists:usuarios,id',
            'menNot' => 'required|string|max:255',
            'fechNot' => 'required|date',
            'estNot' => 'required|in:Activo,Inactivo'
        ]);

        $notificacion = Notificacion::findOrFail($id);
        $notificacion->update($validated);

        return redirect()
            ->route('notificaciones.index')
            ->with('success', 'Notificación actualizada correctamente');
    }

    /**
     * Eliminar notificación
     */
    public function destroy($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->delete();

        return redirect()
            ->route('notificaciones.index')
            ->with('success', 'Notificación eliminada exitosamente.');
    }
}
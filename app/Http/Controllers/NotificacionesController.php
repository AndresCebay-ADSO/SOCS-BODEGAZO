<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\Usuario;
use App\Jobs\SendBulkNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Si es para "todos" (o "all"), la lógica es diferente
        if ($request->input('idUsuNot') === 'all') { // <-- CORREGIDO: ahora comprueba 'all'
            $validated = $request->validate([
                'menNot' => 'required|string|max:255',
                'url' => 'nullable|url|max:255',
            ]);

            // Despachamos la tarea para que se ejecute en segundo plano
            SendBulkNotification::dispatch($validated['menNot'], $validated['url'] ?? null);

            // Redirigimos inmediatamente con un mensaje de éxito
            return redirect()
                ->route('admin.notificaciones.index')
                ->with('success', 'La notificación se ha puesto en cola para ser enviada a todos los usuarios.');
        }

        // Lógica para notificación individual
        $validated = $request->validate([
            'idUsuNot' => 'required|exists:usuarios,id',
            'menNot' => 'required|string|max:255',
            'fechNot' => 'required|date',
            'estNot' => 'required|in:Activo,Inactivo'
        ]);

        Notificacion::create($validated);

        return redirect()->route('admin.notificaciones.index')->with('success', 'Notificación enviada con éxito.');
    }

    public function marcarLeidas()
    {
        auth()->user()->notificaciones()->where('leido', false)->update(['leido' => true]);

        return response()->json(['status' => 'success']);
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
            ->route('admin.notificaciones.index')
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
            ->route('admin.notificaciones.index')
            ->with('success', 'Notificación eliminada exitosamente.');
    }

    /**
     * Obtiene las notificaciones no leídas del usuario autenticado para el menú desplegable.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUnreadNotifications()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications()->latest()->take(5)->get();
        $unreadCount = $user->unreadNotifications()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    public function getUnread()
    {
        return $this->getUnreadNotifications();
    }

    /**
     * Muestra la página con todas las notificaciones para el usuario final.
     *
     * @return \Illuminate\View\View
     */
    public function userIndex()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->latest()->paginate(15);

        // Marcar todas las notificaciones como leídas al visitar la página
        $user->unreadNotifications->markAsRead();

        return view('notifications.index', compact('notifications'));
    }
}
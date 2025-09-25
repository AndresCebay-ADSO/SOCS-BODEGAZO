<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Notificacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule; // BY andres cebay

class AdminController extends Controller
{
    public function index()
    {
        $salesData = Pedido::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('d M'),
                    'count' => $item->count
                ];
        });

        // Estadísticas principales
        $stats = [
            'total_productos' => Producto::count(),
            'productos_bajo_stock' => Producto::where('canPro', '<', 10)->count(),
            'pedidos_pendientes' => Pedido::where('estPed', 'pendiente')->count(),
            'notificaciones_sin_leer' => Notificacion::where('estNot', 'Activo')->count(),
            'inventario_total' => Inventario::sum('canInv'),
        ];

        return view('admin.dashboard', compact('salesData', 'stats'));
    }

    /**
     * Muestra el formulario de edición de perfil
     */
    public function show()
    {
        return view('admin.profile.show', ['user' => auth()->user()]); // Cambiado a user()
    }

    public function edit()
    {
        return view('admin.profile.edit', ['user' => auth()->user()]); // Cambiado a user()
    }

    public function editPassword()
    {
        return view('admin.profile.password', [
            'user' => auth()->user() // Cambiado a user()
        ]);
    }

    /**
     * Actualiza la contraseña del administrador
     */
    public function updatePassword(Request $request)
    {
        // Validación de campos
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, auth()->user()->passUsu)) {
                    $fail('La contraseña actual no es correcta');
                }
            }],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Actualización de la contraseña
        $user = auth()->user();
        $user->passUsu = Hash::make($request->password);
        $user->save();

        // Redirección con mensaje de éxito
        return redirect()
               ->route('admin.profile.show')
               ->with('success', 'Contraseña actualizada correctamente');
    }

    /**
     * Actualiza los datos del perfil del administrador
     * BY andres cebay
     */
  public function update(Request $request)
{
    $request->validate([
        'nomUsu' => 'required|string|max:255',
        'apeUsu' => 'required|string|max:255',
        'emaUsu' => 'required|email',
        'telUsu' => 'nullable|string|max:10',
        'dirUsu' => 'nullable|string|max:255',
    ]);

    $admin = auth()->user(); // o User::find($id) si lo haces por ID

    $admin->nomUsu = $request->nomUsu;
    $admin->apeUsu = $request->apeUsu;
    $admin->emaUsu = $request->emaUsu;
    $admin->telUsu = $request->telUsu;
    $admin->dirUsu = $request->dirUsu;

    $admin->save();

    return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
}


}

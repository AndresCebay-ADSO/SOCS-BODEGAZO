<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Pedido;
use App\Models\FacturaElectronica;
use App\Models\RegistroActividad;
use App\Models\Producto;
use App\Models\Notificacion; // <--- Añadir
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class SuperAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->rol || auth()->user()->rol->nivRol !== Rol::SUPERADMIN) {
                abort(403, 'Acceso no autorizado');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $adminRoleId = Rol::where('nivRol', Rol::ADMIN)->value('idRol');
        $superAdminRoleId = Rol::where('nivRol', Rol::SUPERADMIN)->value('idRol');

        $stats = [
            'total_usuarios' => Usuario::count(),
            'total_administradores' => Usuario::whereIn('idRolUsu', [$adminRoleId, $superAdminRoleId])->count(),
            'pedidos_pendientes' => Pedido::where('estPed', 'pendiente')->count(),
            'facturacion_total' => FacturaElectronica::sum('total') ?? 0,
            'notificaciones_sin_leer' => Notificacion::where('estNot', 'Activo')->count(), // <--- Añadir
        ];

        // --- INICIO: NUEVAS CONSULTAS PARA GRÁFICOS ---

        // Datos para el gráfico de ventas (últimos 7 días)
        $salesDataWeekly = Pedido::selectRaw('DATE(fecPed) as date, COUNT(*) as count')
            ->where('fecPed', '>=', now()->subDays(7)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('Y-m-d'),
                    'count' => $item->count
                ];
            });

        // Datos para el gráfico de ventas (últimos 30 días)
        $salesDataMonthly = Pedido::selectRaw('DATE(fecPed) as date, COUNT(*) as count')
            ->where('fecPed', '>=', now()->subDays(30)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('Y-m-d'),
                    'count' => $item->count
                ];
            });
        
        // Datos para el gráfico de estado de inventario
        $stockStatusData = [
            'in_stock' => Producto::where('canPro', '>', 10)->count(),
            'low_stock' => Producto::whereBetween('canPro', [1, 10])->count(),
            'out_of_stock' => Producto::where('canPro', '=', 0)->count(),
        ];

        // --- FIN: NUEVAS CONSULTAS PARA GRÁFICOS ---

        $activityData = RegistroActividad::selectRaw('DATE_FORMAT(created_at, "%d %b") as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('superadmin.dashboard', compact(
            'stats', 
            'activityData',
            'salesDataWeekly',
            'salesDataMonthly',
            'stockStatusData'
        ));
    }

    public function show()
    {
        $adminRoleId = Rol::where('nivRol', Rol::ADMIN)->value('idRol');
        $superAdminRoleId = Rol::where('nivRol', Rol::SUPERADMIN)->value('idRol');

        $totalUsers = Usuario::count();
        $totalAdmins = Usuario::whereIn('idRolUsu', [$adminRoleId, $superAdminRoleId])->count();
        $todayActions = RegistroActividad::whereDate('created_at', today())->count();
        $recentActivities = RegistroActividad::with('usuario')->latest()->take(5)->get();

        return view('superadmin.profile.show', [
            'user' => Auth::user(),
            'totalUsers' => $totalUsers,
            'totalAdmins' => $totalAdmins,
            'todayActions' => $todayActions,
            'recentActivities' => $recentActivities,
        ]);
    }

    public function edit()
    {
        return view('superadmin.profile.edit', ['user' => Auth::user()]);
    }

    public function editPassword()
    {
        return view('superadmin.profile.password', [
            'user' => Auth::user()
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->passUsu)) {
                    $fail('La contraseña actual no es correcta');
                }
            }],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Auth::user();
        $user->passUsu = Hash::make($request->password);
        $user->save();

        return redirect()
               ->route('superadmin.profile.show')
               ->with('success', 'Contraseña actualizada correctamente');
    }

    public function update(Request $request)
    {
        $request->validate([
            'nomUsu' => 'required|string|max:255',
            'apeUsu' => 'required|string|max:255',
            'emaUsu' => ['required', 'email', Rule::unique('usuarios', 'emaUsu')->ignore(Auth::id())],
            'telUsu' => 'nullable|string|max:10',
            'dirUsu' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->update($request->only(['nomUsu', 'apeUsu', 'emaUsu', 'telUsu', 'dirUsu']));

        return redirect()->route('superadmin.profile.show')
                         ->with('success', 'Perfil actualizado correctamente.');
    }
}
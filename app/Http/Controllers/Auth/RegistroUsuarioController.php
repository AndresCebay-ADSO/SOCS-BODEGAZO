<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Support\Facades\Validator;

class RegistroUsuarioController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Iniciar sesión del usuario (cliente, admin o superadmin)
     */
    public function login(Request $request)
    {
        // Validar datos de entrada
        $request->validate([
            'emaUsu' => 'required|email',
            'passUsu' => 'required|string',
        ]);

        // Buscar usuario por correo
        $usuario = Usuario::where('emaUsu', $request->emaUsu)
                    ->with('rol') // Cargar la relación rol
                    ->first();

        // Verificar si el usuario existe
        if (!$usuario) {
            return back()->withErrors([
                'emaUsu' => 'El correo electrónico no está registrado.',
            ])->withInput();
        }

        // Verificar si el usuario está activo
        if ($usuario->estadoUsu !== 'activo') {
            return back()->withErrors([
                'emaUsu' => 'Tu cuenta está inactiva. Contacta al administrador.',
            ])->withInput();
        }

        // Verificar contraseña
        if (!Hash::check($request->passUsu, $usuario->passUsu)) {
            return back()->withErrors([
                'passUsu' => 'La contraseña es incorrecta.',
            ])->withInput();
        }

        try {
            // Autenticar usuario manualmente
            Auth::login($usuario, $request->has('remember'));

            // Verificar que la autenticación fue exitosa
            if (!Auth::check()) {
                return back()->withErrors([
                    'emaUsu' => 'Error en la autenticación. Intenta nuevamente.',
                ])->withInput();
            }

            // Redirigir según nivel de rol
            switch ($usuario->rol->nivRol) {
                case Rol::SUPERADMIN: // 0
                    return redirect()->route('superadmin.dashboard')->with('success', '¡Bienvenido Superadministrador!');
                case Rol::ADMIN: // 1
                    return redirect()->route('admin.dashboard')->with('success', '¡Bienvenido administrador!');
                case Rol::CLIENTE: // 2
                    return redirect()->route('clientes.dashboard')->with('success', '¡Bienvenido!');
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors([
                        'emaUsu' => 'Rol no autorizado.',
                    ]);
            }
        } catch (\Exception $e) {
            \Log::error('Error en login: ' . $e->getMessage());
            return back()->withErrors([
                'emaUsu' => 'Error al iniciar sesión. Intenta nuevamente.',
            ])->withInput();
        }
    }

    /**
     * Mostrar formulario de registro
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Registrar nuevo usuario (cliente)
     */
    public function register(Request $request)
    {
        $request->validate([
            'nomUsu' => 'required|string|max:100',
            'apeUsu' => 'required|string|max:70',
            'dirUsu' => 'nullable|string|max:50',
            'telUsu' => 'nullable|string|max:10|regex:/^[0-9]+$/',
            'TipdocUsu' => ['required', Rule::in(['Cedula de Ciudadania', 'Tarjeta de Identidad'])],
            'numdocUsu' => 'nullable|string|max:11|unique:usuarios',
            'emaUsu' => 'required|email|max:100|unique:usuarios,emaUsu',
            'passUsu' => 'required|string|min:8|confirmed',
            'terms' => ['required', 'accepted'],
        ], [
            'passUsu.confirmed' => 'Las contraseñas no coinciden',
            'emaUsu.unique' => 'Este correo ya está registrado',
            'numdocUsu.unique' => 'Este documento ya está registrado',
            'terms.required' => 'Debes aceptar los términos y condiciones para registrarte.',
            'terms.accepted' => 'Debes aceptar los términos y condiciones para registrarte.',
        ]);

        DB::beginTransaction();

        try {
            // Obtener el ID del rol cliente
            $rolCliente = Rol::where('nivRol', Rol::CLIENTE)->firstOrFail();

            $usuario = Usuario::create([
                'nomUsu'     => $request->nomUsu,
                'apeUsu'     => $request->apeUsu,
                'dirUsu'     => $request->dirUsu,
                'telUsu'     => $request->telUsu,
                'TipdocUsu'  => $request->TipdocUsu,
                'numdocUsu'  => $request->numdocUsu,
                'emaUsu'     => $request->emaUsu,
                'passUsu'    => Hash::make($request->passUsu),
                'idRolUsu'   => $rolCliente->idRol, // Usamos el ID del rol cliente
                'estadoUsu'  => 'activo',
            ]);

            DB::commit();

            return redirect()->route('login')->with('success', '¡Registro exitoso! Por favor inicia sesión.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error en registro: ' . $e->getMessage());
            return back()->withInput()->withErrors([
                'error' => 'Error al registrar. Intenta nuevamente.'
            ]);
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
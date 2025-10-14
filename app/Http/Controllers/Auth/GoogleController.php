<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Rol;
use Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class GoogleController extends Controller
{
    /**
     * Redirige al usuario a la página de autenticación de Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtiene la información del usuario de Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Busca si el usuario ya existe con su ID de Google, cargando su rol
            $user = Usuario::where('google_id', $googleUser->getId())->with('rol')->first();

            if (!$user) {
                // Si no, buscamos si el email ya está registrado en el sistema
                $user = Usuario::where('emaUsu', $googleUser->getEmail())->with('rol')->first();

                if ($user) {
                    // Si un usuario con ese email ya existe, actualizamos su perfil con el google_id.
                    $user->update(['google_id' => $googleUser->getId()]);
                } else {
                    // Si el email no se encuentra en la base de datos, lo redirigimos con un error.
                    return redirect('/login')->with('error', 'Tu cuenta de Google no está registrada. Por favor, crea una cuenta primero.');
                }
            }
            
            // Verificar si el usuario está activo (lógica importada del login normal)
            if ($user->estadoUsu !== 'activo') {
                return redirect('/login')->with('error', 'Tu cuenta está inactiva. Contacta al administrador.');
            }

            // Autenticar al usuario
            Auth::login($user);

            // Verificar que la autenticación fue exitosa
            if (!Auth::check()) {
                return redirect('/login')->with('error', 'Error en la autenticación con Google. Intenta nuevamente.');
            }

            // Redirigir según el nivel de rol del usuario (lógica importada del login normal)
            switch ($user->rol->nivRol) {
                case 0: // Superadmin
                    return redirect()->route('superadmin.dashboard')->with('success', '¡Bienvenido, ' . $user->nomUsu . ' (Superadministrador)!');
                case 1: // Admin
                    return redirect()->route('admin.dashboard')->with('success', '¡Bienvenido, ' . $user->nomUsu . ' (Administrador)!');
                case 2: // Cliente
                    return redirect()->route('clientes.dashboard')->with('success', '¡Bienvenido, ' . $user->nomUsu . '!');
                default:
                    Auth::logout();
                    return redirect('/login')->with('error', 'Tu rol no está autorizado para iniciar sesión.');
            }

        } catch (Exception $e) {
            Log::error('Error en el callback de Google: ' . $e->getMessage());
            return redirect('/login')->with('error', 'No se pudo iniciar sesión con Google. Por favor, inténtalo de nuevo.');
        }
    }
}
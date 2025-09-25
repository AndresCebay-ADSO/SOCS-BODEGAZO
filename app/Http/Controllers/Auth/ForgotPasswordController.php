<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['emaUsu' => 'required|email|exists:usuarios,emaUsu']);

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->emaUsu],
            [
                'email' => $request->emaUsu,
                'token' => $token,
                'created_at' => now()
            ]
        );

        Mail::raw("Haz clic aquí para restablecer tu contraseña: " . url('/password/reset/' . $token . '?email=' . urlencode($request->emaUsu)), function ($message) use ($request) {
            $message->to($request->emaUsu)
                ->subject('Recupera tu contraseña');
        });

        return back()->with('status', '¡Enlace de recuperación enviado a tu correo!');
    }
} 
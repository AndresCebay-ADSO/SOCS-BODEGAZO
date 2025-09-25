<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'emaUsu' => 'required|email|exists:usuarios,emaUsu',
            'password' => 'required|string|min:6|confirmed',
            'token' => 'required'
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->emaUsu)
            ->where('token', $request->token)
            ->first();

        if (!$record) {
            return back()->withErrors(['email' => 'Token inválido o expirado.']);
        }

        $user = Usuario::where('emaUsu', $request->emaUsu)->first();
        $user->passUsu = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->emaUsu)->delete();

        return redirect()->route('login')->with('status', '¡Contraseña restablecida correctamente!');
    }
} 
<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        \Log::info('RedirectTo triggered', [
            'expectsJson' => $request->expectsJson(),
            'path' => $request->path()
        ]);
        return $request->expectsJson() ? null : route('login');
    }
} 
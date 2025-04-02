<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o usuário está autenticado e se é um administrador
        if (!$request->user() || !$request->user()->is_admin) {
            return response()->json(['message' => 'Acesso negado'], 403);
        }

        return $next($request);
    }
}

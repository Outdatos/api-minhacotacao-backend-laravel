<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user(); // Obtém o usuário autenticado

        if (!$user) {
            return response()->json(['message' => 'Não autenticado'], 401); // Retorna erro 401 se não estiver logado
        }

        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Acesso negado'], 403); // Retorna erro 403 se não for admin
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarRol
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $rolUsuario = strtolower(trim($request->user()->rol));
        $rolesPermitidos = array_map(fn($r) => strtolower(trim($r)), $roles);

        if (!in_array($rolUsuario, $rolesPermitidos)) {
            abort(403, 'No tienes permiso para ingresar a esta sección.');
        }

        return $next($request);
    }
}
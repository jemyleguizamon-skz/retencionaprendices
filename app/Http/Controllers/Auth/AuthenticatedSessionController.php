<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $request->session()->regenerate();

    $user = Auth::user();
    $rol = strtolower(trim($user->rol));

    // Redirección según el rol del usuario
    $rutaRedireccion = match ($rol) {
        'comite' => route('comite.inicio'),
        'aprendiz' => route('aprendiz.inicio'), // Cambia por tus nombres de ruta reales
        'instructor' => route('instructor.inicio'),
        default => route('dashboard'),
    };

    return redirect()->intended($rutaRedireccion);
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

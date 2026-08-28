<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validar los campos
        $request->validate([
            'nombre'     => ['required', 'string', 'max:255'],
            'apellido'   => ['required', 'string', 'max:255'],
            'documento'  => ['required', 'string', 'max:50', 'unique:usuario,documento'],
            'contrasena' => ['required', 'string', 'min:6'],
            'rol'        => ['required', 'string'],
        ]);

        // 2. Crear el usuario en la tabla 'usuario'
        $user = User::create([
            'nombre'     => $request->nombre,
            'apellido'   => $request->apellido,
            'documento'  => $request->documento,
            'contrasena' => Hash::make($request->contrasena),
            'estado'     => 'activo',
            'rol'        => $request->rol,
        ]);

        // se guarda en la tabla 'instructor' 
        if (trim(strtolower($user->rol)) === 'instructor') {
            DB::table('instructor')->insert([
                'nombre'    => $user->nombre,
                'apellido'  => $user->apellido,
                'documento' => $user->documento,
                'ficha'     => 'Sin Asignar',
            ]);
        }

        event(new Registered($user));

        // 3. Iniciar sesión automáticamente
        Auth::login($user);

        // 4. Redirigir según el rol
        return match (trim(strtolower($user->rol))) {
            'aprendiz'         => redirect()->route('aprendiz.inicio'),
            'profesional'      => redirect()->route('area_apoyo.inicio'),
            'instructor'       => redirect()->route('instructor.inicio'),
            'comite'           => redirect()->route('comite.inicio'),
            default            => redirect()->route('login'),
        };
    }
}
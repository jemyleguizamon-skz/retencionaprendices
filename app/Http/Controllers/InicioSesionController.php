<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class InicioSesionController extends Controller
{
    public function iniciarSesion(Request $request)
    {
        $request->validate([
            'documento'  => 'required',
            'contrasena' => 'required',
        ]);

        // 1. Buscar usuario por documento
        $usuario = User::where('documento', $request->documento)->first();

        if (!$usuario) {
            return back()->withErrors(['documento' => 'El documento ingresado no existe.']);
        }

        // 2. Validar contraseña contra el Hash de la BD
        if (!Hash::check($request->contrasena, $usuario->contrasena)) {
            return back()->withErrors(['contrasena' => 'La contraseña es incorrecta.']);
        }

        // 3. Loguear directamente al usuario
        Auth::login($usuario);
        $request->session()->regenerate();

        // 4. Limpiar el rol para evitar problemas de tildes o mayúsculas
        $rol = strtolower(trim($usuario->rol ?? ''));

        // 5. Redireccionar según el rol
        return match ($rol) {
            'aprendiz'    => redirect()->route('aprendiz.inicio'),
            'profesional' => redirect()->route('area_apoyo.inicio'),
            'instructor'  => redirect()->route('instructor.inicio'),
            'comite'      => redirect()->route('comite.inicio'),
            default       => redirect()->route('login')->with('error', 'El rol registrado (' . $rol . ') no tiene una vista asignada.'),
        };
    }
}
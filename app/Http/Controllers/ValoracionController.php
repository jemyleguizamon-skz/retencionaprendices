<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ValoracionController extends Controller
{
    public function create()
    {
        $fichas = DB::table('programa_ficha')
                    ->select('idprograma_ficha', 'ficha')
                    ->distinct()
                    ->get();

        $areas = DB::table('area')
                ->select('idarea', 'nombre')
                ->get();

        $profesionales = DB::table('profesionalcaso')
                        ->select('idprofesionalcaso', 'nombre')
                        ->get();

        $apoyos = DB::table('apoyoinstitucional')->get();

        return view('AreaApoyo.inicio', compact('fichas', 'areas', 'profesionales', 'apoyos'));
    }

    public function storeHistorial(Request $request)
    {
        // 1. Validar los datos del formulario
        $request->validate([
            'nombre_aprendiz'      => 'required|string',
            'ficha'                => 'required',
            'nombre_area'          => 'required',
            'idapoyoinstitucional' => 'required',
            'fecha_inicio'         => 'required|date',
            'descripcion_breve'    => 'required|string',
            'nota'                 => 'required|string',
        ]);

        // 2. Extraer nombre y apellido completo del usuario autenticado
        $nombreRealSesion = null;

        if (Auth::check()) {
            $user = Auth::user();

            // Si existen campos separados de nombre y apellido en la BD/Model
            $primerNombre = $user->name ?? $user->nombre ?? $user->nombres ?? '';
            $apellido     = $user->lastname ?? $user->apellido ?? $user->apellidos ?? '';

            $nombreCompleto = trim($primerNombre . ' ' . $apellido);

            if (!empty($nombreCompleto)) {
                $nombreRealSesion = $nombreCompleto;
            } else {
                $nombreRealSesion = $user->email ?? null;
            }
        }

        // Si la autenticación usa Session directamente
        if (!$nombreRealSesion) {
            $nombreSesion = session('nombre') ?? session('nombres') ?? session('user_name') ?? '';
            $apellidoSesion = session('apellido') ?? session('apellidos') ?? '';
            $nombreCompleto = trim($nombreSesion . ' ' . $apellidoSesion);

            if (!empty($nombreCompleto)) {
                $nombreRealSesion = $nombreCompleto;
            }
        }

        // Si no se logra determinar la sesión, se le notifica al usuario
        if (!$nombreRealSesion) {
            return back()->withErrors(['error' => 'No se detectó un usuario autenticado. Inicie sesión nuevamente.']);
        }

        // 3. Buscar si el profesional ya existe con este nombre y apellido completo
        $profesional = DB::table('profesionalcaso')
            ->where('nombre', $nombreRealSesion)
            ->first();

        if (!$profesional) {
            $idProfesional = DB::table('profesionalcaso')->insertGetId([
                'nombre'      => $nombreRealSesion,
                'area_idarea' => $request->nombre_area
            ]);
        } else {
            $idProfesional = $profesional->idprofesionalcaso;
        }

        // 4. Inserción del registro de acompañamiento
        DB::table('procesoaconmpaniamento')->insert([
            'nombre_aprendiz'      => $request->nombre_aprendiz,
            'ficha'                => $request->ficha,
            'idarea'               => $request->nombre_area,
            'idprofesionalcaso'    => $idProfesional,
            'idapoyoinstitucional' => $request->idapoyoinstitucional,
            'idRiesgoacademico'    => 4,
            'fecha_inicio'         => $request->fecha_inicio,
            'fecha_fin'            => $request->fecha_inicio,
        ]);

        return back()->with('success', 'Valoración guardada exitosamente.');
    }

    public function storeProfesional(Request $request)
    {
        $request->validate([
            'profesional' => 'required|string',
            'area'        => 'required',
        ]);

        DB::table('profesionalcaso')->insert([
            'nombre'      => $request->profesional,
            'area_idarea' => $request->area,
        ]);

        return back()->with('success', 'Profesional registrado correcto.');
    }
}
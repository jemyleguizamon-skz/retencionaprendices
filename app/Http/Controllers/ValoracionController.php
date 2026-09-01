<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValoracionController extends Controller
{
    public function create()
    {
        // Consultamos directamente las tablas con DB::table
        $fichas = DB::table('programa_ficha')
                    ->select('ficha')
                    ->groupBy('ficha')
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
        // 1. Validar los datos que envía el usuario
        $request->validate([
            'nombre_aprendiz'       => 'required|string',
            'ficha'                 => 'required',
            'nombre_area'           => 'required',
            'idapoyoinstitucional'  => 'required',
            'fecha_inicio'          => 'required|date',
            'descripcion_breve'     => 'required|string',
            'nota'                  => 'required|string',
        ]);

        // 2. Obtener el ID del profesional que tiene la sesión activa
        $usuarioLogueadoId = Auth::id();

        // 3. Guardar en la base de datos asociando el ID del profesional activo
        DB::table('historial_valoracion')->insert([
            'nombre_aprendiz'      => $request->nombre_aprendiz,
            'ficha'                => $request->ficha,
            'idarea'               => $request->nombre_area,
            'idprofesionalcaso'    => $idProfesional,
            'idapoyoinstitucional' => $request->idapoyoinstitucional,
            'idRiesgoacademico'    => 4,
            'fecha_inicio'         => $request->fecha_inicio,
            'descripcion_breve'    => $request->descripcion_breve,
            'nota'                 => $request->nota,
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        return back()->with('success', 'Valoración guardada exitosamente.');
    }

    public function indexHistorial()
    {
        // Método para cargar la tabla de "Ver mis valoraciones"
        $nombreRealSesion = null;

        if (Auth::check()) {
            $user = Auth::user();
            $primerNombre = $user->name ?? $user->nombre ?? $user->nombres ?? '';
            $apellido     = $user->lastname ?? $user->apellido ?? $user->apellidos ?? '';
            $nombreRealSesion = trim($primerNombre . ' ' . $apellido);
        }

        $profesional = DB::table('profesionalcaso')
            ->where('nombre', $nombreRealSesion)
            ->first();

        $idProfesional = $profesional ? $profesional->idprofesionalcaso : 0;

        $valoraciones = DB::table('procesoaconmpaniamento')
            ->join('area', 'procesoaconmpaniamento.idarea', '=', 'area.idarea')
            ->leftJoin('apoyoinstitucional', 'procesoaconmpaniamento.idapoyoinstitucional', '=', 'apoyoinstitucional.idapoyoinstitucional')
            ->select('procesoaconmpaniamento.*', 'area.nombre as area_nombre', 'apoyoinstitucional.nombre as apoyo_nombre')
            ->where('procesoaconmpaniamento.idprofesionalcaso', $idProfesional)
            ->get();

        return view('AreaApoyo.historial', compact('valoraciones'));
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

        return back()->with('success', 'Profesional registrado correctamente.');
    }
}
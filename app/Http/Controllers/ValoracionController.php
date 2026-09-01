<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ValoracionController extends Controller
{
    public function create()
    {
        // 1. Agrupar por el número de ficha para que no aparezcan duplicadas
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
        // 1. Validar los datos (sin descripcion_breve ni nota, agregando soporte a archivo)
        $request->validate([
            'nombre_aprendiz'      => 'required|string',
            'ficha'                => 'required',
            'nombre_area'          => 'required',
            'idapoyoinstitucional' => 'required',
            'fecha_inicio'         => 'required|date',
            'archivo_seguimiento'  => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        // 2. Extraer nombre y apellido completo del usuario autenticado
        $nombreRealSesion = null;

        if (Auth::check()) {
            $user = Auth::user();

            $primerNombre = $user->name ?? $user->nombre ?? $user->nombres ?? '';
            $apellido     = $user->lastname ?? $user->apellido ?? $user->apellidos ?? '';

            $nombreCompleto = trim($primerNombre . ' ' . $apellido);

            if (!empty($nombreCompleto)) {
                $nombreRealSesion = $nombreCompleto;
            } else {
                $nombreRealSesion = $user->email ?? null;
            }
        }

        if (!$nombreRealSesion) {
            $nombreSesion   = session('nombre') ?? session('nombres') ?? session('user_name') ?? '';
            $apellidoSesion = session('apellido') ?? session('apellidos') ?? '';
            $nombreCompleto = trim($nombreSesion . ' ' . $apellidoSesion);

            if (!empty($nombreCompleto)) {
                $nombreRealSesion = $nombreCompleto;
            }
        }

        if (!$nombreRealSesion) {
            return back()->withErrors(['error' => 'No se detectó un usuario autenticado. Inicie sesión nuevamente.']);
        }

        // 3. Buscar si el profesional ya existe
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

        // 4. Subida y almacenamiento del archivo
        $rutaArchivo = null;
        if ($request->hasFile('archivo_seguimiento')) {
            $rutaArchivo = $request->file('archivo_seguimiento')->store('seguimientos', 'public');
        }

        // 5. Inserción del registro de acompañamiento
        $datosAInsertar = [
            'nombre_aprendiz'      => $request->nombre_aprendiz,
            'ficha'                => $request->ficha,
            'idarea'               => $request->nombre_area,
            'idprofesionalcaso'    => $idProfesional,
            'idapoyoinstitucional' => $request->idapoyoinstitucional,
            'idRiesgoacademico'    => 4,
            'fecha_inicio'         => $request->fecha_inicio,
            'fecha_fin'            => $request->fecha_inicio,
        ];

        if ($rutaArchivo) {
            $datosAInsertar['archivo'] = $rutaArchivo;
        }

        DB::table('procesoaconmpaniamento')->insert($datosAInsertar);

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
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ValoracionController extends Controller
{
    public function create()
    {
        $fichas = DB::table('programa_ficha')
                    ->select('ficha')
                    ->distinct()
                    ->orderBy('ficha', 'asc')
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
        $request->validate([
            'nombre_aprendiz'      => 'required|string',
            'ficha'                => 'required',
            'nombre_area'          => 'required',
            'idapoyoinstitucional' => 'required',
            'fecha_inicio'         => 'required|date',
            'archivo_seguimiento'  => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        // Obtener el ID del profesional logueado
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

        // Manejar la subida del archivo si existe
        $rutaArchivo = null;
        if ($request->hasFile('archivo_seguimiento')) {
            // Guarda el archivo en storage/app/public/seguimientos
            $rutaArchivo = $request->file('archivo_seguimiento')->store('seguimientos', 'public');
        }

        // Insertar en la base de datos incluyendo la ruta del archivo y fecha_fin
        DB::table('procesoaconmpaniamento')->insert([
            'nombre_aprendiz'      => $request->nombre_aprendiz,
            'ficha'                => $request->ficha,
            'idarea'               => $request->nombre_area,
            'idapoyoinstitucional' => $request->idapoyoinstitucional,
            'fecha_inicio'         => $request->fecha_inicio,
            'fecha_fin'            => $request->fecha_inicio,
            'idprofesionalcaso'    => $idProfesional,
            'archivo'              => $rutaArchivo,
        ]);

        return redirect()->route('valoracion.historial.index')->with('success', 'Valoración guardada exitosamente.');
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

    public function indexHistorial(Request $request)
    {
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

        // Capturar lo que se escribió en el buscador
        $search = $request->input('buscar');

        $query = DB::table('procesoaconmpaniamento')
            ->join('area', 'procesoaconmpaniamento.idarea', '=', 'area.idarea')
            ->leftJoin('apoyoinstitucional', 'procesoaconmpaniamento.idapoyoinstitucional', '=', 'apoyoinstitucional.idapoyoinstitucional')
            ->select('procesoaconmpaniamento.*', 'area.nombre as area_nombre', 'apoyoinstitucional.tipo as apoyo_nombre')
            ->where('procesoaconmpaniamento.idprofesionalcaso', $idProfesional);

        // Si hay texto en el buscador, aplicar el filtro de base de datos
        if ($search) {
            $query->where('procesoaconmpaniamento.nombre_aprendiz', 'LIKE', '%' . $search . '%');
        }

        $valoraciones = $query->get();

        return view('AreaApoyo.historial', compact('valoraciones'));
    }

    public function edit($id)
    {
        // Buscar el registro de acompañamiento por su llave primaria
        $valoracion = DB::table('procesoaconmpaniamento')->where('idProcesoaconmpaniamento', $id)->first();

        if (!$valoracion) {
            return redirect()->route('valoracion.historial.index')->with('error', 'Registro no encontrado.');
        }

        $fichas = DB::table('programa_ficha')
                    ->select('ficha')
                    ->distinct()
                    ->orderBy('ficha', 'asc')
                    ->get();

        $areas = DB::table('area')
                    ->select('idarea', 'nombre')
                    ->get();

        $apoyos = DB::table('apoyoinstitucional')->get();

        return view('AreaApoyo.editar', compact('valoracion', 'fichas', 'areas', 'apoyos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_aprendiz'      => 'required|string',
            'ficha'                => 'required',
            'nombre_area'          => 'required',
            'idapoyoinstitucional' => 'required',
            'fecha_inicio'         => 'required|date',
            'archivo_seguimiento'  => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $valoracion = DB::table('procesoaconmpaniamento')->where('idProcesoaconmpaniamento', $id)->first();

        if (!$valoracion) {
            return redirect()->route('valoracion.historial.index')->with('error', 'Registro no encontrado.');
        }

        $rutaArchivo = $valoracion->archivo;

        // Si se sube un nuevo archivo, actualizar la ruta
        if ($request->hasFile('archivo_seguimiento')) {
            $rutaArchivo = $request->file('archivo_seguimiento')->store('seguimientos', 'public');
        }

        DB::table('procesoaconmpaniamento')
            ->where('idProcesoaconmpaniamento', $id)
            ->update([
                'nombre_aprendiz'      => $request->nombre_aprendiz,
                'ficha'                => $request->ficha,
                'idarea'               => $request->nombre_area,
                'idapoyoinstitucional' => $request->idapoyoinstitucional,
                'fecha_inicio'         => $request->fecha_inicio,
                'fecha_fin'            => $request->fecha_inicio,
                'archivo'              => $rutaArchivo,
            ]);

        return redirect()->route('valoracion.historial.index')->with('success', 'Valoración actualizada exitosamente.');
    }
}
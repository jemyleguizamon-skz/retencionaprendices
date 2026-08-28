<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarioActual = Auth::user();

        // Buscar el idInstructor correspondiente usando el documento del usuario logueado
        $instructor = DB::table('instructor')
            ->where('documento', $usuarioActual->documento) // O 'cedula', según se llame en la tabla usuario
            ->first();

        $idInstructor = $instructor ? $instructor->idInstructor : null;

        // Consultar aprendices asociados a ese instructor
        $aprendices = DB::table('programa_ficha as pf')
            ->join('aprendiz as a', 'pf.idAprendiz', '=', 'a.idAprendiz')
            ->join('riesgoacademico as ra', 'pf.idprograma_ficha', '=', 'ra.idprograma_ficha')
            ->where('ra.idInstructor', $idInstructor)
            ->select('a.nombre', 'a.apellido', 'pf.ficha')
            ->distinct()
            ->get();

        return view('Instructor.inicio', compact('aprendices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programas = DB::table('programa_formacion')->get();
        $instructores = DB::table('instructor')->get(); // Cargar la lista de instructores

        return view('Instructor.formularioaprendiz', compact('programas', 'instructores'));
    }

    public function store(Request $request)
    {
        // 1. Validar los datos del formulario
        $request->validate([
            'id_programa'   => 'required|exists:programa_formacion,idPrograma_formacion',
            'id_instructor' => 'required|exists:instructor,idInstructor',
            'nombre'        => 'required|string|max:255',
            'apellido'      => 'required|string|max:255',
            'ficha'         => 'required|string|max:50',
        ]);

        DB::transaction(function () use ($request) {
            // 2. Insertar en la tabla 'aprendiz'
            $idAprendiz = DB::table('aprendiz')->insertGetId([
                'nombre'   => $request->nombre,
                'apellido' => $request->apellido,
            ]);

            // 3. Insertar en la tabla 'programa_ficha'
            $idProgramaFicha = DB::table('programa_ficha')->insertGetId([
                'idAprendiz'                               => $idAprendiz,
                'programa_formacion_idPrograma_formacion' => $request->id_programa,
                'ficha'                                    => $request->ficha,
            ]);

            // 4. Vincular en la tabla 'riesgoacademico'
            DB::table('riesgoacademico')->insert([
                'idprograma_ficha' => $idProgramaFicha,
                'idInstructor'     => $request->id_instructor, // Seleccionado del desplegable
                'fecha_activacion' => now(),
            ]);
        });

        return redirect()->route('instructor.inicio')->with('success', 'Aprendiz registrado y asignado correctamente.');
    }

    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
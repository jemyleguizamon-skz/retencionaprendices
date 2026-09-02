<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class InstructorController extends Controller
{
    /**
     * Muestra la vista principal del instructor con el listado y filtro de búsqueda.
     */
    public function index(Request $request)
    {
        $usuarioActual = Auth::user();

        // Buscar el idInstructor correspondiente al usuario autenticado
        $instructor = DB::table('instructor')
            ->where('documento', $usuarioActual->documento)
            ->first();

        $idInstructor = $instructor ? $instructor->idInstructor : null;
        $buscar = $request->get('buscar');

        // Consultar aprendices asociados incluyendo archivo y filtro de búsqueda
        $aprendices = DB::table('programa_ficha as pf')
            ->join('aprendiz as a', 'pf.idAprendiz', '=', 'a.idAprendiz')
            ->join('riesgoacademico as ra', 'pf.idprograma_ficha', '=', 'ra.idprograma_ficha')
            ->where('ra.idInstructor', $idInstructor)
            ->when($buscar, function ($query, $buscar) {
                return $query->where(function ($q) use ($buscar) {
                    $q->where('a.nombre', 'LIKE', "%{$buscar}%")
                      ->orWhere('a.apellido', 'LIKE', "%{$buscar}%")
                      ->orWhere('a.archivo', 'LIKE', "%{$buscar}%")
                      ->orWhere('pf.ficha', 'LIKE', "%{$buscar}%");
                });
            })
            ->select('a.archivo', 'a.nombre', 'a.apellido', 'pf.ficha')
            ->distinct()
            ->get();

        return view('Instructor.inicio', compact('aprendices', 'buscar'));
    }

    /**
     * Muestra el formulario para crear un nuevo aprendiz.
     */
    public function create()
    {
        $programas = DB::table('programa_formacion')->get();
        $instructores = DB::table('instructor')->get();

        return view('Instructor.formularioaprendiz', compact('programas', 'instructores'));
    }

    /**
     * Guarda el nuevo aprendiz en la base de datos y procesa el archivo subido.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_programa'   => 'required|exists:programa_formacion,idPrograma_formacion',
            'id_instructor' => 'required|exists:instructor,idInstructor',
            'nombre'        => 'required|string|max:255',
            'apellido'      => 'required|string|max:255',
            'ficha'         => 'required|string|max:50',
            'archivo'       => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120', // Admite archivos de hasta 5MB
        ]);

        DB::transaction(function () use ($request) {
            $rutaArchivo = null;

            // Procesar y guardar el archivo si fue enviado
            if ($request->hasFile('archivo')) {
                $rutaArchivo = $request->file('archivo')->store('archivos', 'public');
            }

            $idAprendiz = DB::table('aprendiz')->insertGetId([
                'archivo'  => $rutaArchivo,
                'nombre'   => $request->nombre,
                'apellido' => $request->apellido,
            ]);

            $idProgramaFicha = DB::table('programa_ficha')->insertGetId([
                'idAprendiz'                               => $idAprendiz,
                'programa_formacion_idPrograma_formacion' => $request->id_programa,
                'ficha'                                    => $request->ficha,
            ]);

            DB::table('riesgoacademico')->insert([
                'idprograma_ficha' => $idProgramaFicha,
                'idInstructor'     => $request->id_instructor,
                'fecha_activacion' => now(),
            ]);
        });

        return redirect()->route('instructor.inicio')->with('success', 'Aprendiz registrado y asignado correctamente.');
    }

    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}

    /**
     * Genera y descarga el reporte en PDF considerando la búsqueda activa.
     */
    public function generarReporteAprendices(Request $request)
    {
        $usuarioActual = Auth::user();

        $instructor = DB::table('instructor')
            ->where('documento', $usuarioActual->documento)
            ->first();

        $idInstructor = $instructor ? $instructor->idInstructor : null;
        $buscar = $request->get('buscar');

        $aprendices = DB::table('programa_ficha as pf')
            ->join('aprendiz as a', 'pf.idAprendiz', '=', 'a.idAprendiz')
            ->join('riesgoacademico as ra', 'pf.idprograma_ficha', '=', 'ra.idprograma_ficha')
            ->where('ra.idInstructor', $idInstructor)
            ->when($buscar, function ($query, $buscar) {
                return $query->where(function ($q) use ($buscar) {
                    $q->where('a.nombre', 'LIKE', "%{$buscar}%")
                        ->orWhere('a.apellido', 'LIKE', "%{$buscar}%")
                        ->orWhere('a.archivo', 'LIKE', "%{$buscar}%")
                        ->orWhere('pf.ficha', 'LIKE', "%{$buscar}%");
                });
            })
            ->select('a.archivo', 'a.nombre', 'a.apellido', 'pf.ficha', 'ra.fecha_activacion')
            ->distinct()
            ->get();

        $pdf = Pdf::loadView('Instructor.reporte_pdf', compact('aprendices'));

        return $pdf->download('reporte_aprendices_' . date('Ymd') . '.pdf');
    }
}
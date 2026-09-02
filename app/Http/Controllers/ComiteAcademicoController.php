<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComiteAcademicoController extends Controller
{
    public function index(Request $request)
    {
        // Capturar lo que se escribió en la barra de búsqueda
        $search = $request->input('buscar');

        // Consulta los acompañamientos trayendo los nombres reales mediante LEFT JOIN
        $query = DB::table('procesoaconmpaniamento')
            ->leftJoin('area', 'procesoaconmpaniamento.idarea', '=', 'area.idarea')
            ->leftJoin('profesionalcaso', 'procesoaconmpaniamento.idprofesionalcaso', '=', 'profesionalcaso.idprofesionalcaso')
            ->select(
                'procesoaconmpaniamento.*',
                'area.nombre as nombre_area',
                'profesionalcaso.nombre as nombre_profesional'
            );

        // Si hay texto en el buscador, filtrar por el nombre del aprendiz
        if ($search) {
            $query->where('procesoaconmpaniamento.nombre_aprendiz', 'LIKE', '%' . $search . '%');
        }

        $seguimientos = $query->get();

        return view('ComiteAcademico.inicio', compact('seguimientos'));
    }
}
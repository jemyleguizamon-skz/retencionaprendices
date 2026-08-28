<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComiteAcademicoController extends Controller
{
    public function index()
    {
        // Consulta los acompañamientos trayendo los nombres reales mediante LEFT JOIN
        $seguimientos = DB::table('procesoaconmpaniamento')
            ->leftJoin('area', 'procesoaconmpaniamento.idarea', '=', 'area.idarea')
            ->leftJoin('profesionalcaso', 'procesoaconmpaniamento.idprofesionalcaso', '=', 'profesionalcaso.idprofesionalcaso')
            ->select(
                'procesoaconmpaniamento.*',
                'area.nombre as nombre_area',
                'profesionalcaso.nombre as nombre_profesional'
            )
            ->get();

        return view('ComiteAcademico.inicio', compact('seguimientos'));
    }
}
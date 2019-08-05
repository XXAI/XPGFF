<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fuente;
use App\Models\TipoNomina;
use App\Models\Programa;
use App\Models\Puesto;
use App\Models\Rama;
use App\Models\Profesion;

class PersonalActivoController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $datos = [
            'activo'=>'personal-activo',
            'mostrar_filtro'=>true,
            'mostrar_grupos'=>true,
            'mostrar_estatus'=>true,
            'programas' => Programa::orderBy('descripcion')->get(),
            'fuentes' => Fuente::orderBy('descripcion')->get(),
            'tipos_nomina' => TipoNomina::orderBy('descripcion')->get(),
            'puestos' => Puesto::orderBy('descripcion')->get(),
            'ramas' => Rama::orderBy('descripcion')->get(),
            'profesiones' => Profesion::orderBy('descripcion')->get(),
        ];
        return view('personal-activo',$datos);
    }
}

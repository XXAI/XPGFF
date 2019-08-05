<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Programa;
use App\Models\Fuente;
use App\Models\TipoNomina;
use App\Models\Puesto;

class PlantillaConcentradoController extends Controller
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
            'activo'=>'concentrado',
            'mostrar_filtro'=>true,
            'programas' => Programa::orderBy('descripcion')->get(),
            'fuentes' => Fuente::orderBy('descripcion')->get(),
            'tipos_nomina' => TipoNomina::orderBy('descripcion')->get(),
            'puestos' => Puesto::orderBy('descripcion')->get(),
            //'ramos' => Puesto::orderBy('descripcion')->get(),
            //'profesiones' => Puesto::orderBy('descripcion')->get(),
        ];
        return view('plantilla-concentrado',$datos);
    }
}

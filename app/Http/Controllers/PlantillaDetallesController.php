<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fuente;
use App\Models\TipoNomina;
use App\Models\Programa;
use App\Models\Puesto;

class PlantillaDetallesController extends Controller
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
            'activo'=>'detalles',
            'mostrar_filtro'=>true,
            'mostrar_grupos'=>true,
            'programas' => Programa::orderBy('descripcion')->get(),
            'fuentes' => Fuente::orderBy('descripcion')->get(),
            'tipos_nomina' => TipoNomina::orderBy('descripcion')->get(),
            'puestos' => Puesto::orderBy('descripcion')->get()
        ];
        return view('plantilla-detalles',$datos);
    }
}

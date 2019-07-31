<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fuente;
use App\Models\TipoNomina;
use App\Models\Programa;
use App\Models\CLUES;

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
            'buscar'=>true,
            'fuentes'=>Fuente::all(),
            'tipos_nomina'=>TipoNomina::all(),
            'programas' => Programa::all(),
            'clues' => CLUES::all()
        ];
        return view('plantilla-detalles',$datos);
    }
}

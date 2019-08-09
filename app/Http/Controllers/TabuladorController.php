<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Programa;
use App\Models\Fuente;
use App\Models\TipoNomina;
use App\Models\Puesto;
use App\Models\Tabulador;

class TabuladorController extends Controller
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
            'activo'=>'tabulador',
            'mostrar_filtro'=>true,
            'mostrar_filtro_pasantes'=>true,
            'programas' => Programa::orderBy('descripcion')->get(),
            'fuentes' => Fuente::orderBy('descripcion')->get(),
            'tipos_nomina' => TipoNomina::orderBy('descripcion')->get(),
            'puestos' => Puesto::orderBy('descripcion')->get(),
            'tabulador' => [['id'=>0, 'descripcion'=>'Tabuladores']],
        ];
        return view('tabulador',$datos);
    }
}

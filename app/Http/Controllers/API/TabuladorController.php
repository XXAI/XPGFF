<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Models\Personal;
use App\Models\TipoNomina;
use App\Models\Fuente;
use App\Models\Tabulador;
use DB;

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
        $parametros = Input::all();

        $fuentes = Fuente::orderBy('descripcion')->get();
        $plazas = TipoNomina::orderBy('descripcion')->get();
        $tabulador = Tabulador::all();

        $personal = Personal::select('personal_instituto.tipo_nomina_id','personal_instituto.fuente_id','personal_instituto.puesto','catalogo_puesto.tabulador_id',DB::raw('count(distinct rfc) as num_empleados'))
                            ->leftJoin('catalogo_puesto','catalogo_puesto.codigo','=','personal_instituto.puesto')
                            ->leftJoin('catalogo_tabulador','catalogo_tabulador.id','=','catalogo_puesto.tabulador_id')
                            ->groupBy('personal_instituto.tipo_nomina_id','personal_instituto.fuente_id','catalogo_puesto.tabulador_id');

        if($parametros['programa_id']){
            $personal = $personal->where('programa_id',$parametros['programa_id']);
        }

        if($parametros['fuente_id']){
            $personal = $personal->where('fuente_id',$parametros['fuente_id']);
        }

        if($parametros['tipo_nomina_id']){
            $personal = $personal->where('tipo_nomina_id',$parametros['tipo_nomina_id']);
        }

        if($parametros['puesto']){
            $personal = $personal->where('puesto',$parametros['puesto']);
        }

        if($parametros['fecha_inicio']){
            $personal = $personal->where('fissa','>=',$parametros['fecha_inicio']);
        }

        if($parametros['fecha_fin']){
            $personal = $personal->where('fissa','<=',$parametros['fecha_fin']);
        }

        if(!isset($parametros['mostrar_pasantes'])){
            $personal = $personal->where('ur','!=','610');

            /* Aqui haremos un chequeo rapido, y veremos si la condicion indicada nos sigue dando resultados en este tipo de tabulador, en caso de ser asi, se mostrara el tabulador para poder identificar el error */
            $personal_pasantes = clone $personal;

            //El tabulador id 6 es RECURSO HUMANO EN FORMACION (los pasantes)
            $personal_pasantes = $personal_pasantes->where('catalogo_puesto.tabulador_id',6)->get();

            if(count($personal_pasantes) == 0){
                $tabulador = Tabulador::where('id','!=',6)->get();
            }
        }

        $personal = $personal->get();

        $tabla_fuentes = [];
        $tabla_plazas = [];

        foreach($fuentes as $fuente){
            $tabla_fuentes[$fuente->id] = ['fuente'=>$fuente->descripcion, 'tabulador'=>[]];
        }

        foreach($plazas as $plaza){
            $tabla_plazas[$plaza->id] = ['plaza'=>$plaza->descripcion, 'tabulador'=>[]];
        }

        foreach($personal as $persona){
            if(!isset($tabla_fuentes[$persona->fuente_id]['tabulador'][$persona->tabulador_id])){
                $tabla_fuentes[$persona->fuente_id]['tabulador'][$persona->tabulador_id] = $persona->num_empleados;
            }else{
                $tabla_fuentes[$persona->fuente_id]['tabulador'][$persona->tabulador_id] += $persona->num_empleados;
            }

            if(!isset($tabla_plazas[$persona->tipo_nomina_id]['tabulador'][$persona->tabulador_id])){
                $tabla_plazas[$persona->tipo_nomina_id]['tabulador'][$persona->tabulador_id] = $persona->num_empleados;
            }else{
                $tabla_plazas[$persona->tipo_nomina_id]['tabulador'][$persona->tabulador_id] += $persona->num_empleados;
            }
        }

        return response()->json(['fuentes'=>$tabla_fuentes,'plazas'=>$tabla_plazas, 'tabuladores'=>$tabulador], HttpResponse::HTTP_OK);
    }
}

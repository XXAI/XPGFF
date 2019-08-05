<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Models\Personal;
use DB;

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
        $parametros = Input::all();

        $lista_detalles = Personal::select('activo','comision_sindical','personal_instituto.descripcion as puesto', 'catalogo_tipo_nomina.descripcion as tipo_nomina','catalogo_rama.descripcion as rama',DB::raw('count(distinct rama_id) as conteo_rama'),'catalogo_profesion.descripcion as profesion',DB::raw('count(distinct profesion_id) as conteo_profesion'), DB::raw('count(distinct tipo_nomina_id) as conteo_nomina'), 'catalogo_programa.descripcion as programa', DB::raw('count(distinct programa_id) as conteo_programa'), 'catalogo_fuente.descripcion as fuente', DB::raw('count(distinct fuente_id) as conteo_fuente'), DB::raw('sum(percepcion) as total_percepcion'), DB::raw('count(distinct rfc) as total_personas'))
                            ->leftJoin('catalogo_tipo_nomina','catalogo_tipo_nomina.id','=','tipo_nomina_id')
                            //->leftJoin('catalogo_puesto','catalogo_puesto.codigo','=','puesto')
                            ->leftJoin('catalogo_programa','catalogo_programa.id','=','programa_id')
                            ->leftJoin('catalogo_rama','catalogo_rama.id','=','rama_id')
                            ->leftJoin('catalogo_profesion','catalogo_profesion.id','=','profesion_id')
                            ->leftJoin('catalogo_fuente','catalogo_fuente.id','=','fuente_id')
                            ->where('ur','!=','610')
                            ->orderBy('personal_instituto.descripcion')
                            ->groupBy('puesto');

        if(isset($parametros['group_tipo_nomina'])){
            $lista_detalles = $lista_detalles->groupBy('tipo_nomina_id');
        }

        if(isset($parametros['group_fuente'])){
            $lista_detalles = $lista_detalles->groupBy('fuente_id');
        }

        if(isset($parametros['group_programa'])){
            $lista_detalles = $lista_detalles->groupBy('programa_id');
        }

        if(isset($parametros['group_rama'])){
            $lista_detalles = $lista_detalles->groupBy('rama_id');
        }

        if(isset($parametros['group_profesion'])){
            $lista_detalles = $lista_detalles->groupBy('profesion_id');
        }
        
        if(isset($parametros['estatus'])){
            if($parametros['estatus'] == 1){
                $lista_detalles = $lista_detalles->where('activo',1);
            }else if($parametros['estatus'] == 0){
                $lista_detalles = $lista_detalles->where('activo',0);
            }
        }

        if(isset($parametros['sindicato'])){
            if($parametros['sindicato'] == 1){
                $lista_detalles = $lista_detalles->where('comision_sindical',1);
            }else if($parametros['sindicato'] == 0){
                $lista_detalles = $lista_detalles->where('comision_sindical',0);
            }
        }
    
        if($parametros['rama_id']){
            $lista_detalles = $lista_detalles->where('rama_id',$parametros['rama_id']);
        }

        if($parametros['profesion_id']){
            $lista_detalles = $lista_detalles->where('profesion_id',$parametros['profesion_id']);
        }

        if($parametros['programa_id']){
            $lista_detalles = $lista_detalles->where('programa_id',$parametros['programa_id']);
        }

        if($parametros['fuente_id']){
            $lista_detalles = $lista_detalles->where('fuente_id',$parametros['fuente_id']);
        }

        if($parametros['tipo_nomina_id']){
            $lista_detalles = $lista_detalles->where('tipo_nomina_id',$parametros['tipo_nomina_id']);
        }

        if($parametros['puesto']){
            $lista_detalles = $lista_detalles->where('puesto',$parametros['puesto']);
        }

        if($parametros['fecha_inicio']){
            $lista_detalles = $lista_detalles->where('fissa','>=',$parametros['fecha_inicio']);
        }

        if($parametros['fecha_fin']){
            $lista_detalles = $lista_detalles->where('fissa','<=',$parametros['fecha_fin']);
        }

        if(isset($parametros['page'])){
            $resultadosPorPagina = isset($parametros["per_page"])? $parametros["per_page"] : 25;
            $lista_detalles = $lista_detalles->paginate($resultadosPorPagina);
        } else {
            $lista_detalles = $lista_detalles->get();
        }

        return response()->json(['paginado'=>$lista_detalles], HttpResponse::HTTP_OK);
    }
}

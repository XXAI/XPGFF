<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Models\Personal;
use DB;

class ListaDetallesPersonalController extends Controller
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

        $lista_detalles = Personal::select('activo','comision_sindical','personal_instituto.rfc','personal_instituto.curp','personal_instituto.nombre','catalogo_puesto.descripcion as puesto', 'catalogo_rama.descripcion as rama','catalogo_profesion.descripcion as profesion','personal_instituto.clues')
                            ->leftJoin('catalogo_puesto','catalogo_puesto.codigo','=','puesto')
                            ->leftJoin('catalogo_rama','catalogo_rama.id','=','rama_id')
                            ->leftJoin('catalogo_profesion','catalogo_profesion.id','=','profesion_id')
                            ->where('ur','!=','610')
                            ->where('puesto',$parametros['modal_puesto'])
                            ->orderBy('personal_instituto.nombre');

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
    
        if($parametros['modal_rama']){
            $lista_detalles = $lista_detalles->where('rama_id',$parametros['modal_rama']);
        }

        if($parametros['modal_profesion']){
            $lista_detalles = $lista_detalles->where('profesion_id',$parametros['modal_profesion']);
        }

        if($parametros['modal_programa']){
            $lista_detalles = $lista_detalles->where('programa_id',$parametros['modal_programa']);
        }

        if($parametros['modal_fuente']){
            $lista_detalles = $lista_detalles->where('fuente_id',$parametros['modal_fuente']);
        }

        if($parametros['modal_tipo_nomina']){
            $lista_detalles = $lista_detalles->where('tipo_nomina_id',$parametros['modal_tipo_nomina']);
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

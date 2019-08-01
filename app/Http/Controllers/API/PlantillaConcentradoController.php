<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Models\Personal;
use DB;

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
        $parametros = Input::all();

        $lista_por_tipo_nomina = Personal::select('catalogo_tipo_nomina.descripcion as tipo_nomina', 'tipo_nomina_id',DB::raw('sum(percepcion) as total_percepcion'), DB::raw('count(distinct rfc) as total_personas'))
                            ->leftJoin('catalogo_tipo_nomina','catalogo_tipo_nomina.id','=','tipo_nomina_id')
                            ->where('ur','!=','610')
                            ->groupBy('tipo_nomina_id');

        $lista_por_fuente_finan = Personal::select('tipo_nomina_id', 'catalogo_fuente.llave as fuente','fuente_id',DB::raw('sum(percepcion) as total_percepcion'), DB::raw('count(distinct rfc) as total_personas'))
                            ->leftJoin('catalogo_fuente','catalogo_fuente.id','=','fuente_id')
                            ->where('ur','!=','610')
                            ->groupBy('tipo_nomina_id','fuente_id');

        if($parametros['programa_id']){
            $lista_por_tipo_nomina = $lista_por_tipo_nomina->where('programa_id',$parametros['programa_id']);
            $lista_por_fuente_finan = $lista_por_fuente_finan->where('programa_id',$parametros['programa_id']);
        }

        if($parametros['fuente_id']){
            $lista_por_tipo_nomina = $lista_por_tipo_nomina->where('fuente_id',$parametros['fuente_id']);
            $lista_por_fuente_finan = $lista_por_fuente_finan->where('fuente_id',$parametros['fuente_id']);
        }

        if($parametros['tipo_nomina_id']){
            $lista_por_tipo_nomina = $lista_por_tipo_nomina->where('tipo_nomina_id',$parametros['tipo_nomina_id']);
            $lista_por_fuente_finan = $lista_por_fuente_finan->where('tipo_nomina_id',$parametros['tipo_nomina_id']);
        }

        if($parametros['puesto']){
            $lista_por_tipo_nomina = $lista_por_tipo_nomina->where('puesto',$parametros['puesto']);
            $lista_por_fuente_finan = $lista_por_fuente_finan->where('puesto',$parametros['puesto']);
        }

        if($parametros['fecha_inicio']){
            $lista_por_tipo_nomina = $lista_por_tipo_nomina->where('fissa','>=',$parametros['fecha_inicio']);
            $lista_por_fuente_finan = $lista_por_fuente_finan->where('fissa','>=',$parametros['fecha_inicio']);
        }

        if($parametros['fecha_fin']){
            $lista_por_tipo_nomina = $lista_por_tipo_nomina->where('fissa','<=',$parametros['fecha_fin']);
            $lista_por_fuente_finan = $lista_por_fuente_finan->where('fissa','<=',$parametros['fecha_fin']);
        }

        $lista_por_tipo_nomina = $lista_por_tipo_nomina->get();
        $lista_por_fuente_finan = $lista_por_fuente_finan->get();

        $personal = [];
        $fuentes = [];
        foreach($lista_por_tipo_nomina as $registro){
            if(!isset($personal[$registro->tipo_nomina_id])){
                $personal[$registro->tipo_nomina_id] = [
                    'descripcion' => $registro->tipo_nomina,
                    'total' => $registro->total_percepcion,
                    'total_personas' => $registro->total_personas,
                    'fuentes' => []
                ];
            }
        }

        foreach($lista_por_fuente_finan as $registro){
            if(!isset($personal[$registro->tipo_nomina_id]['fuentes'][$registro->fuente_id])){
                $personal[$registro->tipo_nomina_id]['fuentes'][$registro->fuente_id] = [
                    'total' => $registro->total_percepcion
                ];
            }
            if(!isset($fuentes[$registro->fuente_id])){
                $fuentes[$registro->fuente_id] = $registro->fuente;
            }
        }
        
        return response()->json(['personal'=>$personal,'fuentes'=>$fuentes], HttpResponse::HTTP_OK);
    }
}

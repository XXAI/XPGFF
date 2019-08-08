<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Models\Personal;
use DB;

class DatosPersonaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id){
        $persona = Personal::select('personal_instituto.id','activo','comision_sindical','personal_instituto.rfc','personal_instituto.curp','personal_instituto.nombre','personal_instituto.crespdes','personal_instituto.fissa','personal_instituto.figf','catalogo_puesto.descripcion as puesto', 'catalogo_rama.descripcion as rama','catalogo_profesion.descripcion as profesion','catalogo_programa.descripcion as programa','catalogo_fuente.descripcion as fuente','catalogo_tipo_nomina.descripcion as tipo_nomina')
                            ->leftJoin('catalogo_puesto','catalogo_puesto.codigo','=','puesto')
                            ->leftJoin('catalogo_rama','catalogo_rama.id','=','rama_id')
                            ->leftJoin('catalogo_profesion','catalogo_profesion.id','=','profesion_id')
                            ->leftJoin('catalogo_programa','catalogo_programa.id','=','programa_id')
                            ->leftJoin('catalogo_fuente','catalogo_fuente.id','=','fuente_id')
                            ->leftJoin('catalogo_tipo_nomina','catalogo_tipo_nomina.id','=','tipo_nomina_id')
                            ->where('personal_instituto.id',$id)
                            ->first();
        
        return response()->json(['persona'=>$persona], HttpResponse::HTTP_OK);
    }
}

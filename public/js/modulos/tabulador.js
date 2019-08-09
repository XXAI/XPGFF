function aplicarFiltro(){
    actualizarRegistros();
}

function actualizarRegistros(){
    var parametros = $("#formulario-filtro").serialize();

    $('#concentrado-fuente').html('<tr><th colspan="'+($('#tabla-por-fuente th.tabulador').length+2)+'" class="text-center"><i class="fas fa-spinner fa-pulse"></i> Cargando...</th></th></tr>');
    $('#concentrado-plaza').html('<tr><th colspan="'+($('#tabla-por-plaza th.tabulador').length+2)+'" class="text-center"><i class="fas fa-spinner fa-pulse"></i> Cargando...</th></th></tr>');

    $.get('api/tabulador', parametros, function(data){
        console.log(data);

        var header_nivel_atencion = '<tr>';
        var body_nivel_atencion = '<tr>';
        for(var i in data.niveles_atencion){
            header_nivel_atencion += '<th>'+data.niveles_atencion[i].nivel+'</th>';
            body_nivel_atencion += '<td class="text-center">'+data.niveles_atencion[i].total.format()+'</td>';
        }
        header_nivel_atencion += '</tr>';
        body_nivel_atencion += '</tr>';

        $('#tabla-por-nivel-atencion thead').html(header_nivel_atencion);
        $('#tabla-por-nivel-atencion tbody').html(body_nivel_atencion);

        var header_por_fuente = '<th>FUENTE DE FINANCIAMIENTO</th>';
        var header_por_plaza = '<th>PLAZAS</th>';
        for(var i in data.tabuladores){
            header_por_fuente += '<th class="tabulador" data-id="'+data.tabuladores[i].id+'">'+data.tabuladores[i].descripcion+'</th>';
            header_por_plaza += '<th class="tabulador" data-id="'+data.tabuladores[i].id+'">'+data.tabuladores[i].descripcion+'</th>';
        }
        header_por_fuente += '<th>TOTAL</th>';
        header_por_plaza += '<th>TOTAL</th>';

        $('#header-tabla-por-fuente').html(header_por_fuente);
        $('#header-tabla-por-plaza').html(header_por_plaza);

        var tabuladores = $('#tabla-por-fuente th.tabulador'); //.data('id');

        var registros_fuentes = '';
        var total_fuentes_tabulador = [];
        var total_fuentes = 0;
        for(var i in data.fuentes){
            var fuente = data.fuentes[i];

            var total_fuente = 0;
            registros_fuentes += '<tr><td>'+fuente.fuente+'</td>';
            for(var j = 0 ; j < tabuladores.length ; j++){
                var tab_id = $(tabuladores[j]).data('id');

                if(!total_fuentes_tabulador[tab_id]){
                    total_fuentes_tabulador[tab_id] = 0;
                }

                if(fuente.tabulador[tab_id]){
                    registros_fuentes += '<td class="text-right">'+fuente.tabulador[tab_id].format()+'</td>';
                    total_fuente += fuente.tabulador[tab_id];
                    total_fuentes += fuente.tabulador[tab_id];
                    total_fuentes_tabulador[tab_id] += fuente.tabulador[tab_id];
                }else{
                    registros_fuentes += '<td class="text-right">0</td>';
                }
            }
            registros_fuentes += '<th class="text-right">'+total_fuente.format()+'</th></tr>';
        }

        registros_fuentes += '<tr class="bg-light"><th class="text-right">Totales</th>';
        for(var j = 0 ; j < tabuladores.length ; j++){
            var tab_id = $(tabuladores[j]).data('id');
            if(total_fuentes_tabulador[tab_id]){
                registros_fuentes += '<th class="text-right">'+total_fuentes_tabulador[tab_id].format()+'</th>';
            }else{
                registros_fuentes += '<th class="text-right">0</th>';
            }
        }
        registros_fuentes += '<th class="text-right">'+total_fuentes.format()+'</th></tr>';
        $('#concentrado-fuente').html(registros_fuentes);


        tabuladores = $('#tabla-por-plaza th.tabulador'); //.data('id');

        var registros_plazas = '';
        var total_plazas_tabulador = [];
        var total_plazas = 0;
        for(var i in data.plazas){
            var plaza = data.plazas[i];

            var total_plaza = 0;
            registros_plazas += '<tr><td>'+plaza.plaza+'</td>';
            for(var j = 0 ; j < tabuladores.length ; j++){
                var tab_id = $(tabuladores[j]).data('id');

                if(!total_plazas_tabulador[tab_id]){
                    total_plazas_tabulador[tab_id] = 0;
                }

                if(plaza.tabulador[tab_id]){
                    registros_plazas += '<td class="text-right">'+plaza.tabulador[tab_id].format()+'</td>';
                    total_plaza += plaza.tabulador[tab_id];
                    total_plazas += plaza.tabulador[tab_id];
                    total_plazas_tabulador[tab_id] += plaza.tabulador[tab_id];
                }else{
                    registros_plazas += '<td class="text-right">0</td>';
                }
            }
            registros_plazas += '<th class="text-right">'+total_plaza.format()+'</th></tr>';
        }

        registros_plazas += '<tr class="bg-light"><th class="text-right">Totales</th>';
        for(var j = 0 ; j < tabuladores.length ; j++){
            var tab_id = $(tabuladores[j]).data('id');
            if(total_plazas_tabulador[tab_id]){
                registros_plazas += '<th class="text-right">'+total_plazas_tabulador[tab_id].format()+'</th>';
            }else{
                registros_plazas += '<th class="text-right">0</th>';
            }
        }
        registros_plazas += '<th class="text-right">'+total_plazas.format()+'</th></tr>';
        $('#concentrado-plaza').html(registros_plazas);


    });
}

window.onload = function () { aplicarFiltro(); }

/**
 * Number.prototype.format(n, x)
 * 
 * @param integer n: length of decimal
 * @param integer x: length of sections
 */
Number.prototype.format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};

function roundToTwo(num) {    
    return +(Math.round(num + "e+2")  + "e-2");
}
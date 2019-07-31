function aplicarFiltro(){
    //$('#pagina_actual').val('1');
    actualizarRegistros();
}

function actualizarRegistros(){
    var parametros = $("#formulario-filtro").serialize();
    //parametros += '&page='+$('#pagina_actual').val();

    $.get('api/concentrado', parametros, function(data){
        console.log(data);
        var registros = "";
        var fuentes = "";

        var total_percepcion = {total:0};
        var total_personas = 0;

        for(var i in data.fuentes){
            fuentes +=  '<th>'+data.fuentes[i]+'</th>';
        }
        $('#titulo_fuentes').attr('colSpan',''+i);
        $('#fuentes').html(fuentes);

        for(var i in data.personal){
            var registro = data.personal[i];

            total_personas += registro.total_personas;
            total_percepcion['total'] += registro.total; 

            registros += '<tr><td>'+registro.descripcion+'</td><td class="text-center font-weight-bold">'+registro.total_personas.format()+'</td><td class="text-center font-weight-bold">$'+registro.total.format(2)+'</td>';
            for(var j in data.fuentes){
                if(registro.fuentes[j]){
                    registros += '<td class="text-center">$'+registro.fuentes[j].total.format(2)+'</td>';
                    if(!total_percepcion[j]){
                        total_percepcion[j] = registro.fuentes[j].total;
                    }else{
                        total_percepcion[j] += registro.fuentes[j].total;
                    }
                }else{
                    registros += '<td class="text-center">$0.00</td>';
                }
            }
            registros += '</tr>';
        }

        registros += '<tr class="bg-secondary text-white font-weight-bold"><td>Totales</td><td class="text-center">'+total_personas.format()+'</td><td class="text-center">$'+total_percepcion['total'].format(2)+'</td>';
        for(var j in data.fuentes){
            registros += '<td class="text-center">$'+total_percepcion[j].format(2)+'</td>';
        }
        registros += '</tr>';

        $('#concentrado_tipo_nomina').html(registros);


        /*
        <tr><td>tipo nomina</td><td class="text-center">total</td><td class="text-center">1</td><td class="text-center">2</td><td class="text-center">3</td><td class="text-center">4</td><td class="text-center">5</td></tr>
        
        
        $('#lista_registros').html(registros);

        $('#total_paginas').val(data['paginado'].last_page);
        $('#total_asistentes').text(data['paginado'].total);
        */
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

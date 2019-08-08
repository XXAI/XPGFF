function aplicarFiltro(){
    $('#pagina-actual').val('1');
    actualizarRegistros();
}

function actualizarRegistros(){
    $('#lista-registros').html('<tr><th colspan="6" class="text-center"><i class="fas fa-spinner fa-pulse"></i> Cargando...</th></th></tr>');

    var parametros = $("#formulario-filtro").serialize();
    parametros += '&page='+$('#pagina-actual').val();

    $.get('api/detalles', parametros, function(data){
        var registros = "";
        var total_personas = 0;
        var total_percepcion = 0;
        for(var i in data['paginado'].data){
            var elemento = data['paginado'].data[i];

            if(elemento.conteo_nomina > 1){
                elemento.tipo_nomina = elemento.conteo_nomina + ' Nominas Diferentes';
            }

            if(elemento.conteo_programa > 1){
                elemento.programa = elemento.conteo_programa + ' Programas Diferentes';
            }

            if(elemento.conteo_fuente > 1){
                elemento.fuente = elemento.conteo_fuente + ' Fuentes Diferentes';
            }

            registros += "<tr><td>"+elemento.puesto+"</td><td>"+elemento.tipo_nomina+"</td><td>"+elemento.programa+"</td><td>"+elemento.fuente+"</td><td class='text-center'>"+elemento.total_personas.format()+"</td><td class='text-center'>$"+elemento.total_percepcion.format(2)+"</td></tr>";

            total_personas += elemento.total_personas;
            total_percepcion += elemento.total_percepcion;
        }
        registros += "<tr class='bg-light'><th class='text-right' colspan='4'>SubTotal: </th><th class='text-center'>"+total_personas.format()+"</th><th class='text-center'>$"+total_percepcion.format(2)+"</th></tr>";
        $('#lista-registros').html(registros);

        $('#total-paginas').val(data['paginado'].last_page);
        $('#span-total-paginas').text(data['paginado'].last_page);
        $('#span-total-registros').text(data['paginado'].total);

        actualizarPaginador();
    });
}

function actualizarPaginador(){
    var pag_actual = $('#pagina-actual').val();
    var total_paginas = $('#total-paginas').val();

    /* class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true" */
    if(pag_actual == 1){
        $('.pagina-anterior-primera').attr('aria-disabled','true');
        $('.pagina-anterior-primera').attr('tabindex',-1);
        $('.pagina-anterior-primera').addClass('disabled');
    }else{
        $('.pagina-anterior-primera').attr('aria-disabled',false);
        $('.pagina-anterior-primera').attr('tabindex',false);
        $('.pagina-anterior-primera').removeClass('disabled');
    }

    if(pag_actual == total_paginas){
        $('.pagina-siguiente-ultima').attr('aria-disabled','true');
        $('.pagina-siguiente-ultima').attr('tabindex',-1);
        $('.pagina-siguiente-ultima').addClass('disabled');
    }else{
        $('.pagina-siguiente-ultima').attr('aria-disabled',false);
        $('.pagina-siguiente-ultima').attr('tabindex',false);
        $('.pagina-siguiente-ultima').removeClass('disabled');
    }
}

function cargarPagina(pagina=''){
    var cargar_pagina = $('#pagina-actual').val()*1;
    var total_paginas = $('#total-paginas').val()*1;
    switch (pagina) {
        case 'siguiente':
            if(cargar_pagina < total_paginas){
                cargar_pagina++;
            }
            break;
        case 'anterior':
            if(cargar_pagina > 1){
                cargar_pagina--;
            }
            break;
        case 'primera':
            cargar_pagina = 1;
                break;
        case 'ultima':
            cargar_pagina = total_paginas;
            break;
        default:
            if(cargar_pagina > total_paginas){
                cargar_pagina = total_paginas;
            }else if(cargar_pagina < 0){
                cargar_pagina = 1;
            }
            break;
    }
    $('#pagina-actual').val(cargar_pagina);
    actualizarRegistros();
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

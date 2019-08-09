function aplicarFiltro(){
    $('#pagina-actual').val('1');
    actualizarRegistros();
}

function actualizarRegistros(){
    $('#lista-registros').html('<tr><th colspan="8" class="text-center"><i class="fas fa-spinner fa-pulse"></i> Cargando...</th></tr>');

    var parametros = $("#formulario-filtro").serialize();
    parametros += '&page='+$('#pagina-actual').val();

    $.get('api/personal-activo', parametros, function(data){
        var registros = "";
        var total_personas = 0;
        var total_percepcion = 0;
        for(var i in data['paginado'].data){
            var elemento = data['paginado'].data[i];

            if(elemento.conteo_nomina > 1){
                elemento.tipo_nomina = elemento.conteo_nomina + ' Nominas Diferentes';
                elemento.tipo_nomina_id = 0;
            }

            if(elemento.conteo_programa > 1){
                elemento.programa = elemento.conteo_programa + ' Programas Diferentes';
                elemento.programa_id = 0;
            }

            if(elemento.conteo_fuente > 1){
                elemento.fuente = elemento.conteo_fuente + ' Fuentes Diferentes';
                elemento.fuente_id = 0;
            }

            if(elemento.conteo_rama > 1){
                elemento.rama = elemento.conteo_rama + ' Ramas Diferentes';
                elemento.rama_id = 0;
            }

            if(elemento.conteo_profesion > 1){
                elemento.profesion = elemento.conteo_profesion + ' Profesiones Diferentes';
                elemento.profesion_id = 0;
            }

            registros += "<tr><td><a href='#' onclick='mostrarDetalles(event,\""+elemento.puesto_id+"\","+elemento.rama_id+","+elemento.profesion_id+","+elemento.tipo_nomina_id+","+elemento.programa_id+","+elemento.fuente_id+");' >"+elemento.puesto+"</a></td><td>"+elemento.rama+"</td><td>"+elemento.profesion+"</td><td>"+elemento.tipo_nomina+"</td><td>"+elemento.programa+"</td><td>"+elemento.fuente+"</td><td class='text-center'>"+elemento.total_personas.format()+"</td><td class='text-center'>$"+elemento.total_percepcion.format(2)+"</td></tr>";

            total_personas += elemento.total_personas;
            total_percepcion += elemento.total_percepcion;
        }
        
        if(data['paginado'].last_page > 1){
            registros += "<tr class='bg-light'><th class='text-right' colspan='6'>Subtotal: </th><th class='text-center'>"+total_personas.format()+"</th><th class='text-center'>$"+total_percepcion.format(2)+"</th></tr>";
            registros += "<tr class='bg-dark text-white'><th class='text-right' colspan='6'>Total: </th><th class='text-center'>"+data['totales'][0].total_personas.format()+"</th><th class='text-center'>$"+data['totales'][0].total_percepcion.format(2)+"</th></tr>";
        }else{
            registros += "<tr class='bg-dark text-white'><th class='text-right' colspan='6'>Total: </th><th class='text-center'>"+total_personas.format()+"</th><th class='text-center'>$"+total_percepcion.format(2)+"</th></tr>";
        }

        $('#lista-registros').html(registros);

        $('#total-paginas').val(data['paginado'].last_page);
        $('#span-total-paginas').text(data['paginado'].last_page);
        $('#span-total-registros').text(data['paginado'].total);

        actualizarPaginador();
    });
}

function mostrarDetalles(event,puesto,rama = 0,profesion = 0,tipo_nomina = 0,programa = 0,fuente = 0){
    event.preventDefault();

    $('#modal_puesto').val(puesto);
    
    if(rama){           $('#modal_rama').val(rama);                 }else{      $('#modal_rama').val(''); }
    if(profesion){      $('#modal_profesion').val(profesion);       }else{      $('#modal_profesion').val(''); }
    if(tipo_nomina){    $('#modal_tipo_nomina').val(tipo_nomina);   }else{      $('#modal_tipo_nomina').val(''); }
    if(programa){       $('#modal_programa').val(programa);         }else{      $('#modal_programa').val(''); }
    if(fuente){         $('#modal_fuente').val(fuente);             }else{      $('#modal_fuente').val(''); }

    $('#modal-detalles-personal').modal('show');
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

function actualizarRegistrosModal(){
    $('#detalles-persona').hide();
    $('#panel-datos-persona').hide();
    $('#cargando-datos-persona').hide();
    $('#paginado-detalles-personas').css("height", "");
    $('#lista-detalles').html('<tr><th colspan="6" class="text-center"><i class="fas fa-spinner fa-pulse"></i> Cargando...</th></tr>');

    var parametros = $("#formulario-modal").serialize();
    parametros += '&fecha_inicio='+$('#fecha_inicio').val()+'&fecha_fin='+$('#fecha_fin').val()+'&estatus='+$('#estatus').val()+'&sindicato='+$('#sindicato').val()+'&page='+$('#modal-pagina-actual').val();

    $.get('api/personal-activo-detalles', parametros, function(data){
        var registros = "";
        var total_personas = 0;
        var total_percepcion = 0;
        for(var i in data['paginado'].data){
            var elemento = data['paginado'].data[i];

            registros += "<tr onclick='mostrarDetallesPersona(this,"+elemento.id+");' style='cursor:pointer;'><td>"+elemento.rfc+"</td><td>"+elemento.curp+"</td><td>"+elemento.nombre+"</td><td>"+elemento.puesto+"</td><td>"+elemento.rama+"</td><td>"+elemento.profesion+"</td><td>"+elemento.proporcionado_por+"</td></tr>";
        }

        $('#lista-detalles').html(registros);

        $('#modal-total-paginas').val(data['paginado'].last_page);
        $('#modal-span-total-paginas').text(data['paginado'].last_page);
        $('#modal-span-total-registros').text(data['paginado'].total);

        actualizarPaginadorModal();
    });
}

function mostrarDetallesPersona(el,id){
    $('#lista-detalles tr.bg-info').removeClass('bg-info text-white');
    $(el).addClass('bg-info text-white');
    $('#detalles-persona').show();
    $('#panel-datos-persona').hide();
    $('#cargando-datos-persona').show();

    $.get('api/datos-persona/'+id, null, function(data){
        console.log(data.persona);
        var persona = data.persona;
        var html_info = "<div class='col-1 text-right font-weight-bold'>RFC</div>"+
                        "<div class='col-2'><p>"+persona.rfc+"</p></div>"+
                        "<div class='col-1 text-right font-weight-bold'>CURP</div>"+
                        "<div class='col-2'><p>"+persona.curp+"</p></div>"+
                        "<div class='col-2 text-right font-weight-bold'>Tipo Nomina</div>"+
                        "<div class='col-4'><p>"+persona.tipo_nomina+"</p></div>"+

                        "<div class='col-1 text-right font-weight-bold'>Nombre</div>"+
                        "<div class='col-3'><p>"+persona.nombre+"</p></div>"+
                        "<div class='col-2 text-right font-weight-bold'>Fecha Ingreso SSA</div>"+
                        "<div class='col-2'><p>"+persona.fissa+"</p></div>"+
                        "<div class='col-2 text-right font-weight-bold'>Fecha Ingreso Gobierno Federal</div>"+
                        "<div class='col-2'><p>"+persona.figf+"</p></div>"+

                        "<div class='col-1 text-right font-weight-bold'>Fuente</div>"+
                        "<div class='col-3'><p>"+persona.fuente+"</p></div>"+
                        "<div class='col-1 text-right font-weight-bold'>Programa</div>"+
                        "<div class='col-2'><p>"+persona.programa+"</p></div>"+
                        "<div class='col-1 text-right font-weight-bold'>Crespdes</div>"+
                        "<div class='col-4'><p>"+persona.crespdes+"</p></div>"+
                        
                        "<div class='col-1 text-right font-weight-bold'>Puesto</div>"+
                        "<div class='col-3'><p>"+persona.puesto+"</p></div>"+
                        "<div class='col-1 text-right font-weight-bold'>Rama</div>"+
                        "<div class='col-2'><p>"+persona.rama+"</p></div>"+
                        "<div class='col-1 text-right font-weight-bold'>Profesion</div>"+
                        "<div class='col-3'><p>"+persona.profesion+"</p></div>";
        $('#panel-datos-persona').html(html_info);

        $('#cargando-datos-persona').hide();
        $('#panel-datos-persona').show();

        $('#paginado-detalles-personas').css("height", "50%");

        $('#modal-detalles-personal').modal('handleUpdate');
    });

}

function cerrarDetallesPersona(){
    $('#lista-detalles tr.bg-info').removeClass('bg-info text-white');
    $('#detalles-persona').hide();

    $('#paginado-detalles-personas').css("height", "");
    
    $('#modal-detalles-personal').modal('handleUpdate');
}

function actualizarPaginadorModal(){
    var pag_actual = $('#modal-pagina-actual').val();
    var total_paginas = $('#modal-total-paginas').val();

    /* class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true" */
    if(pag_actual == 1){
        $('.modal-pagina-anterior-primera').attr('aria-disabled','true');
        $('.modal-pagina-anterior-primera').attr('tabindex',-1);
        $('.modal-pagina-anterior-primera').addClass('disabled');
    }else{
        $('.modal-pagina-anterior-primera').attr('aria-disabled',false);
        $('.modal-pagina-anterior-primera').attr('tabindex',false);
        $('.modal-pagina-anterior-primera').removeClass('disabled');
    }

    if(pag_actual == total_paginas){
        $('.modal-pagina-siguiente-ultima').attr('aria-disabled','true');
        $('.modal-pagina-siguiente-ultima').attr('tabindex',-1);
        $('.modal-pagina-siguiente-ultima').addClass('disabled');
    }else{
        $('.modal-pagina-siguiente-ultima').attr('aria-disabled',false);
        $('.modal-pagina-siguiente-ultima').attr('tabindex',false);
        $('.modal-pagina-siguiente-ultima').removeClass('disabled');
    }
}

function cargarPaginaModal(pagina=''){
    var cargar_pagina = $('#modal-pagina-actual').val()*1;
    var total_paginas = $('#modal-total-paginas').val()*1;
    
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
    
    $('#modal-pagina-actual').val(cargar_pagina);
    actualizarRegistrosModal();
}

window.onload = function () { aplicarFiltro(); }

$(document).ready(function() {
    $('#modal-detalles-personal').on('show.bs.modal', function (event) {
        $('#modal-pagina-actual').val(1);
        actualizarRegistrosModal();
    });
});

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

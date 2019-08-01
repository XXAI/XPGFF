function aplicarFiltro(){
    //$('#pagina_actual').val('1');
    actualizarRegistros();
}

function actualizarRegistros(){
    var parametros = $("#formulario-filtro").serialize();
    //parametros += '&page='+$('#pagina_actual').val();

    $.get('api/concentrado', parametros, function(data){
        console.log(data);

        var dynamicColors = function() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return {bg:"rgba("+r+","+g+","+b+",0.2)", br:"rgba("+r+","+g+","+b+",1)",key:r+","+g+","+b};
         };

         var chrtBackgroundColors = [];
         var chrtBorderColors = [];
        /*var chrtBackgroundColors = [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
        ];*/

        var registros = "";
        var fuentes = "";

        var total_percepcion = {total:0};
        var total_personas = 0;

        var chrt_datasets = [];
        var colores = {};
        for(var i in data.personal){
            var color = {};

            do {
                color = dynamicColors();
            } while (colores[color.key]);
            colores[color.key] = true;

            var registro = data.personal[i];
            var chrt_datos_nomina = {label:'', data:[], backgroundColor: color.bg, borderColor: color.br, borderWidth:3};

            total_personas += registro.total_personas;
            total_percepcion['total'] += registro.total; 

            chrt_datos_nomina.label = registro.descripcion;

            registros += '<tr><td>'+registro.descripcion+'</td><td class="text-center font-weight-bold">'+registro.total_personas.format()+'</td><td class="text-center font-weight-bold">$'+registro.total.format(2)+'</td>';
            for(var j in data.fuentes){
                if(registro.fuentes[j]){
                    registros += '<td class="text-center">$'+registro.fuentes[j].total.format(2)+'</td>';
                    if(!total_percepcion[j]){
                        total_percepcion[j] = registro.fuentes[j].total;
                    }else{
                        total_percepcion[j] += registro.fuentes[j].total;
                    }
                    chrt_datos_nomina.data.push(roundToTwo(registro.fuentes[j].total));
                }else{
                    registros += '<td class="text-center">$0.00</td>';
                    chrt_datos_nomina.data.push(0);
                }
            }
            registros += '</tr>';
            chrt_datasets.push(chrt_datos_nomina);
        }

        registros += '<tr class="bg-secondary text-white font-weight-bold"><td>Totales</td><td class="text-center">'+total_personas.format()+'</td><td class="text-center">$'+total_percepcion['total'].format(2)+'</td>';

        var chrt_fuentes = [];
        for(var i in data.fuentes){
            registros += '<td class="text-center">$'+total_percepcion[i].format(2)+'</td>';

            fuentes +=  '<th>'+data.fuentes[i]+'</th>';
            chrt_fuentes.push(data.fuentes[i]+' $'+total_percepcion[i].format(2));
        }
        registros += '</tr>';
        $('#titulo_fuentes').attr('colSpan',''+i);
        $('#fuentes').html(fuentes);

        $('#concentrado_tipo_nomina').html(registros);

        $('#chart-container').html('<canvas id="myChart"></canvas>');
        var ctx = $('#myChart');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chrt_fuentes,
                datasets: chrt_datasets
            },
            options: {
                responsive:true,
                scales: {
                    xAxes: [{
                        barPercentage:1,
                        categoryPercentage:1,
                        stacked: true
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                            console.log(tooltipItem);
                            if (label) {
                                label += ': $';
                            }
                            label += tooltipItem.yLabel.format(2);
                            return label;
                        }
                    }
                }
            }
        });
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
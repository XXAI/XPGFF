@extends('layouts.app')

@section('title', 'Plantilla por QNA')

@section('javascript')
<script src="{{asset('js/Chart.bundle.min.js')}}"></script>
<script src="{{asset('js/modulos/concentrado.js')}}"></script>
@endsection

@section('raw_content')
<br>
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="flex-sm-fill text-sm-center nav-item nav-link active" id="nav-table-tab" data-toggle="tab" href="#nav-table" role="tab" aria-controls="nav-table" aria-selected="true"><i class="fas fa-table"></i> Tabla</a>
    <a class="flex-sm-fill text-sm-center nav-item nav-link" id="nav-chart-tab" data-toggle="tab" href="#nav-chart" role="tab" aria-controls="nav-chart" aria-selected="false"><i class="fas fa-chart-pie"></i> Grafica</a>
  </div>
</nav>
<br>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-table" role="tabpanel" aria-labelledby="nav-table-tab">
    <div class="table-responsive">
        <table class="table table-sm table-hover shadow">
            <thead class="thead-dark text-center">
                <tr>
                    <th rowspan="2">TIPO NOMINA</th>
                    <th rowspan="2">TOTAL PERSONAS</th>
                    <th rowspan="2">TOTAL PERCEPCION</th>
                    <th id="titulo_fuentes" colspan="5">FUENTES DE FINANCIAMIENTO</th>
                </tr>
                <tr id="fuentes">
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>5</th>
                </tr>
            </thead>
            <tbody id="concentrado_tipo_nomina">
                <tr><td colspan="8">Cargando...</td></tr>
            </tbody>
        </table>
    </div>
  </div>
  <div class="tab-pane fade" id="nav-chart" role="tabpanel" aria-labelledby="nav-chart-tab">
    <div class="row">
        <div class="col-10 offset-1">
            <div class="card">
                <div class="card-body">
                    <div id="chart-container" class="chart-container" style="position: relative; height:20vh; width:100%">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection
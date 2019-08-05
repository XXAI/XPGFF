@extends('layouts.app')

@section('title', 'Analisis de Personal Activo')

@section('javascript')
<script src="{{asset('js/modulos/personal-activo.js')}}"></script>
@endsection

@section('raw_content')
<div class="table-responsive">
    <table class="table table-sm table-hover">
        <thead class="thead-dark">
            <tr class="text-center">
                <th>PUESTO</th>
                <th>RAMA</th>
                <th>PROFESION</th>
                <th>TIPO NOMINA</th>
                <th>PROGRAMA</th>
                <th>FUENTE</th>
                <th>TOTAL PERSONAS</th>
                <th>TOTAL PERCEPCIÓN</th>
            </tr>
        </thead>
        <tbody id="lista-registros">
            <tr><td colspan="8">Cargando</td></tr>
        </tbody>
    </table>
</div>

<ul class="nav justify-content-center bg-light ">
    <span class="navbar-text">
        Total Registros: <span id="span-total-registros">1</span>
    </span>
    <li class="nav-item">
        <a class="pagina-anterior-primera nav-link disabled" href="#" tabindex="-1" aria-disabled="true" onclick="cargarPagina('primera')"><i class="fas fa-angle-double-left"></i> Primer Página</a>
    </li>
    <li class="nav-item">
        <a class="pagina-anterior-primera nav-link disabled" href="#" tabindex="-1" aria-disabled="true" onclick="cargarPagina('anterior')"><i class="fas fa-angle-left"></i> Anterior</a>
    </li>
    <li>
        <form class="form-inline my-2 my-lg-0">
            <input type="number" class="form-control mr-sm-2" placeholder="Página" aria-label="Pagina" id="pagina-actual" value="1">
            <button type="button" class="btn btn-outline-primary my-2 my-sm-0" onclick="cargarPagina()">Ir</button>
        </form>
    </li>
    <li class="nav-item">
        <a class="pagina-siguiente-ultima nav-link" href="#" onclick="cargarPagina('siguiente')">Siguiente <i class="fas fa-angle-right"></i></a>
    </li>
    <li class="nav-item">
        <a class="pagina-siguiente-ultima nav-link" href="#" onclick="cargarPagina('ultima')">Ultima Página <i class="fas fa-angle-double-right"></i></a>
    </li>
    <span class="navbar-text">
        Total Paginas:<span id="span-total-paginas">1</span>
        <input type="hidden" id="total-paginas">
    </span>
</ul>
@endsection

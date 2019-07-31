@extends('layouts.app')

@section('title', 'Plantilla por QNA')

@section('javascript')
@endsection

@section('raw_content')
<div class="table-responsive">
    <table class="table table-sm table-hover">
        <thead class="thead-dark">
            <tr>
                <th>NUMEMP</th>
                <th>RFC</th>
                <th>CURP</th>
                <th>NOMBRE</th>
                <!--th>UR</th-->
                <th>TIPO NOMINA</th>
                <th>PROGAMA</th>
                <th>FUENTE</th>
                <th>PUESTO</th>
                <th>PERCEPCIÓN</th>
                <th>DEDUCCIÓN</th>
                <th>LIQUIDO</th>
                <!--th>TABPTO</th-->
                <th>FISSA</th>
                <!--th>CR</th-->
                <th>CLUES</th>
                <!--th>CRESPDES</th-->
            </tr>
        </thead>
        <tbody>
            @for($i= 0; $i < 5; $i++)
            <tr><td>NUMEMP</td><td>RFC</td><td>CURP</td><td>NOMBRE</td><td>TIPO NOMINA</td><td>PROGAMA</td><td>FUENTE</td><td>PUESTO</td><td>PERCEPCIÓN</td><td>DEDUCCIÓN</td><td>LIQUIDO</td><td>FISSA</td><td>CLUES</td></tr>
            <tr><td>NUMEMP</td><td>RFC</td><td>CURP</td><td>NOMBRE</td><td>TIPO NOMINA</td><td>PROGAMA</td><td>FUENTE</td><td>PUESTO</td><td>PERCEPCIÓN</td><td>DEDUCCIÓN</td><td>LIQUIDO</td><td>FISSA</td><td>CLUES</td></tr>
            <tr><td>NUMEMP</td><td>RFC</td><td>CURP</td><td>NOMBRE</td><td>TIPO NOMINA</td><td>PROGAMA</td><td>FUENTE</td><td>PUESTO</td><td>PERCEPCIÓN</td><td>DEDUCCIÓN</td><td>LIQUIDO</td><td>FISSA</td><td>CLUES</td></tr>
            <tr><td>NUMEMP</td><td>RFC</td><td>CURP</td><td>NOMBRE</td><td>TIPO NOMINA</td><td>PROGAMA</td><td>FUENTE</td><td>PUESTO</td><td>PERCEPCIÓN</td><td>DEDUCCIÓN</td><td>LIQUIDO</td><td>FISSA</td><td>CLUES</td></tr>
            <tr><td>NUMEMP</td><td>RFC</td><td>CURP</td><td>NOMBRE</td><td>TIPO NOMINA</td><td>PROGAMA</td><td>FUENTE</td><td>PUESTO</td><td>PERCEPCIÓN</td><td>DEDUCCIÓN</td><td>LIQUIDO</td><td>FISSA</td><td>CLUES</td></tr>
            <tr><td>NUMEMP</td><td>RFC</td><td>CURP</td><td>NOMBRE</td><td>TIPO NOMINA</td><td>PROGAMA</td><td>FUENTE</td><td>PUESTO</td><td>PERCEPCIÓN</td><td>DEDUCCIÓN</td><td>LIQUIDO</td><td>FISSA</td><td>CLUES</td></tr>
            <tr><td>NUMEMP</td><td>RFC</td><td>CURP</td><td>NOMBRE</td><td>TIPO NOMINA</td><td>PROGAMA</td><td>FUENTE</td><td>PUESTO</td><td>PERCEPCIÓN</td><td>DEDUCCIÓN</td><td>LIQUIDO</td><td>FISSA</td><td>CLUES</td></tr>
            <tr><td>NUMEMP</td><td>RFC</td><td>CURP</td><td>NOMBRE</td><td>TIPO NOMINA</td><td>PROGAMA</td><td>FUENTE</td><td>PUESTO</td><td>PERCEPCIÓN</td><td>DEDUCCIÓN</td><td>LIQUIDO</td><td>FISSA</td><td>CLUES</td></tr>
            <tr><td>NUMEMP</td><td>RFC</td><td>CURP</td><td>NOMBRE</td><td>TIPO NOMINA</td><td>PROGAMA</td><td>FUENTE</td><td>PUESTO</td><td>PERCEPCIÓN</td><td>DEDUCCIÓN</td><td>LIQUIDO</td><td>FISSA</td><td>CLUES</td></tr>
            <tr><td>NUMEMP</td><td>RFC</td><td>CURP</td><td>NOMBRE</td><td>TIPO NOMINA</td><td>PROGAMA</td><td>FUENTE</td><td>PUESTO</td><td>PERCEPCIÓN</td><td>DEDUCCIÓN</td><td>LIQUIDO</td><td>FISSA</td><td>CLUES</td></tr>
            @endfor
        </tbody>
    </table>
</div>

<ul class="nav justify-content-center bg-light fixed-bottom">
    <span class="navbar-text">
        Total Registros: <span id="span-total-registros">1</span>
    </span>
    <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"><i class="fas fa-angle-double-left"></i> Primer Página</a>
    </li>
    <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"><i class="fas fa-angle-left"></i> Anterior</a>
    </li>
    <li>
        <form class="form-inline my-2 my-lg-0">
            <input type="number" class="form-control mr-sm-2" placeholder="Página" aria-label="Pagina" id="buscar-pagina" value="1">
            <button type="button" class="btn btn-outline-primary my-2 my-sm-0">Ir</button>
        </form>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Siguiente <i class="fas fa-angle-right"></i></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Ultima Página <i class="fas fa-angle-double-right"></i></a>
    </li>
    <span class="navbar-text">
        Página <span id="span-pagina-actual">1</span> de <span id="span-total-paginas">1</span>
    </span>
</ul>
@endsection

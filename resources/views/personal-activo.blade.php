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
            <tr><th colspan="8" class="text-center"><i class="fas fa-spinner fa-pulse"></i> Cargando...</th></tr>
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


<div class="modal fade" id="modal-detalles-personal" tabindex="-1" role="dialog" aria-labelledby="modal-detalles-personal-title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document" >
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal-detalles-personal-title">Personal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="padding-left:0px; padding-right:0px; padding-top:0px;">
            <form id="formulario-modal">
                <input type="hidden" id="modal_puesto" name="modal_puesto">
                <input type="hidden" id="modal_rama" name="modal_rama">
                <input type="hidden" id="modal_profesion" name="modal_profesion">
                <input type="hidden" id="modal_tipo_nomina" name="modal_tipo_nomina">
                <input type="hidden" id="modal_programa" name="modal_programa">
                <input type="hidden" id="modal_fuente" name="modal_fuente">
            </form>
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th>RFC</th>
                            <th>CURP</th>
                            <th>NOMBRE</th>
                            <th>PUESTO</th>
                            <th>RAMA</th>
                            <th>PROFESION</th>
                        </tr>
                    </thead>
                    <tbody id="lista-detalles">
                        <tr><th colspan="6" class="text-center"><i class="fas fa-spinner fa-pulse"></i> Cargando...</th></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <ul class="nav justify-content-center bg-light ">
            <span class="navbar-text">
                Total Registros: <span id="modal-span-total-registros">1</span>
            </span>
            <li class="nav-item">
                <a class="modal-pagina-anterior-primera nav-link disabled" href="#" tabindex="-1" aria-disabled="true" onclick="cargarPaginaModal('primera')"><i class="fas fa-angle-double-left"></i> Primer Página</a>
            </li>
            <li class="nav-item">
                <a class="modal-pagina-anterior-primera nav-link disabled" href="#" tabindex="-1" aria-disabled="true" onclick="cargarPaginaModal('anterior')"><i class="fas fa-angle-left"></i> Anterior</a>
            </li>
            <li>
                <form class="form-inline my-2 my-lg-0">
                    <input type="number" class="form-control mr-sm-2" placeholder="Página" aria-label="Pagina" id="modal-pagina-actual" value="1">
                    <button type="button" class="btn btn-outline-primary my-2 my-sm-0" onclick="cargarPaginaModal()">Ir</button>
                </form>
            </li>
            <li class="nav-item">
                <a class="modal-pagina-siguiente-ultima nav-link" href="#" onclick="cargarPaginaModal('siguiente')">Siguiente <i class="fas fa-angle-right"></i></a>
            </li>
            <li class="nav-item">
                <a class="modal-pagina-siguiente-ultima nav-link" href="#" onclick="cargarPaginaModal('ultima')">Ultima Página <i class="fas fa-angle-double-right"></i></a>
            </li>
            <span class="navbar-text">
                Total Paginas:<span id="modal-span-total-paginas">1</span>
                <input type="hidden" id="modal-total-paginas">
            </span>
        </ul>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
  </div>
</div>
@endsection

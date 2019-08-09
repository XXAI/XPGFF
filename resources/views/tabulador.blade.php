@extends('layouts.app')

@section('title', 'Tabulador')

@section('javascript')
<script src="{{asset('js/modulos/tabulador.js')}}"></script>
@endsection

@section('raw_content')
<div style="padding:10px;">
    <br>
    <div class="table-responsive">
        <table id="tabla-por-fuente" class="table table-sm table-hover shadow">
            <thead class="thead-dark text-center">
                <tr id="header-tabla-por-fuente">
                    <th>FUENTE DE FINANCIAMIENTO</th>
                    @foreach($tabulador as $tab)
                        <th class="tabulador" data-id="{{$tab['id']}}">{{$tab['descripcion']}}</th>
                    @endforeach
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody id="concentrado-fuente">
                <tr><th colspan="{{count($tabulador)+2}}" class="text-center"><i class="fas fa-spinner fa-pulse"></i> Cargando...</th></th></tr>
            </tbody>
        </table>
    </div>
    <hr>
    <div class="table-responsive">
        <table id="tabla-por-plaza" class="table table-sm table-hover shadow">
            <thead class="thead-dark text-center">
                <tr id="header-tabla-por-plaza">
                    <th>PLAZAS</th>
                    @foreach($tabulador as $tab)
                        <th class="tabulador" data-id="{{$tab['id']}}">{{$tab['descripcion']}}</th>
                    @endforeach
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody id="concentrado-plaza">
                <tr><th colspan="{{count($tabulador)+2}}" class="text-center"><i class="fas fa-spinner fa-pulse"></i> Cargando...</th></th></tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

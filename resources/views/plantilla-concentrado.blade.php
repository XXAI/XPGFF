@extends('layouts.app')

@section('title', 'Plantilla por QNA')

@section('javascript')
<script src="{{asset('js/modulos/concentrado.js')}}"></script>
@endsection

@section('raw_content')
<br>
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
            <tr><td>tipo nomina</td><td class="text-center">total</td><td class="text-center">1</td><td class="text-center">2</td><td class="text-center">3</td><td class="text-center">4</td><td class="text-center">5</td></tr>
        </tbody>
    </table>
</div>
@endsection
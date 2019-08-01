<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="{{asset('fontawesome/css/all.min.css')}}">
        <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
        
        @section('css')
        @show

        <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
        <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>

        @section('javascript')
        @show
    </head>
    <body style="padding-top:57px; padding-bottom:57px;">
        <nav class="navbar navbar-dark bg-dark navbar-expand-lg shadow fixed-top">
            <a class="navbar-brand" href="#">
                <img src="{{asset('images/logo-estatal-icon.svg')}}" width="30" height="30" class="d-inline-block align-top" alt="">
                Plantilla General
            </a>
            @if(Auth::check())
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav w-100">
                        <li class="nav-item {{(isset($activo) && $activo == 'concentrado')?'active':''}}">
                            <a class="nav-link" href="concentrado">Concentrado</a>
                        </li>
                        <li class="nav-item {{(isset($activo) && $activo == 'detalles')?'active':''}}" >
                            <a class="nav-link" href="detalles">Detalles</a>
                        </li>
                    </ul>
                </div>
            
                <a class="btn btn-outline-info my-2 my-sm-0" href="logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
            @endif
        </nav>
        @if(Auth::check() && isset($mostrar_filtro) && $mostrar_filtro)
            <div class="bg-info text-white" style="padding:10px;">
                <form id="formulario-filtro">
                    <div class="form-row">
                        
                        <div class="form-group col">
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                        </div>
                        <div class="form-group col">
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                        </div>

                        @if(isset($fuentes))
                        <div class="form-group col">
                            <select id="fuente_id" name="fuente_id" class="form-control">
                                <option value='' selected>Seleccione una fuente</option>
                                @foreach($fuentes as $fuente)
                                <option value='{{$fuente->id}}'>{{$fuente->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        @if(isset($tipos_nomina))
                        <div class="form-group col">
                            <select id="tipo_nomina_id" name="tipo_nomina_id" class="form-control">
                                <option value='' selected>Seleccione un tipo de nomina</option>
                                @foreach($tipos_nomina as $tipo_nomina)
                                <option value='{{$tipo_nomina->id}}'>{{$tipo_nomina->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        @if(isset($programas))
                        <div class="form-group col">
                            <select id="programa_id" name="programa_id" class="form-control">
                                <option value='' selected>Seleccione un programa</option>
                                @foreach($programas as $programa)
                                <option value='{{$programa->id}}'>{{$programa->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif


                        @if(isset($puestos))
                        <div class="form-group col">
                            <select id="puesto" name="puesto" class="form-control">
                                <option value='' selected>Seleccione un puesto</option>
                                @foreach($puestos as $puesto)
                                <option value='{{$puesto->codigo}}'>{{$puesto->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        @if(isset($mostrar_grupos))
                        <div class="col">
                            <!--legend class="col-form-label">Agrupar Por:</legend-->
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="group_tipo_nomina" name="group_tipo_nomina" value="1">
                                <label class="form-check-label" for="group_tipo_nomina">Tipo Nomina</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="group_fuente" name="group_fuente" value="1">
                                <label class="form-check-label" for="group_fuente">Fuente</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="group_programa" name="group_programa" value="1">
                                <label class="form-check-label" for="group_programa">Programa</label>
                            </div>
                            <!--button type="button" class="btn btn-info"><i class="fas fa-file-excel"></i> Exportar</button-->
                        </div>
                        @endif

                        <div class="form-group col">
                            <button type="button" class="btn btn-primary btn-block" onclick="aplicarFiltro()"><i class="fas fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </form>
            </div>
        @endif
        @section('raw_content')
        @show
        <div class="container">
            @section('content')
            @show
        </div>
    </body>
</html>
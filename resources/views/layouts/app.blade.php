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
    <body style="padding-top:57px; padding-bottom:5px;">
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
                        <li class="nav-item {{(isset($activo) && $activo == 'personal-activo')?'active':''}}" >
                            <a class="nav-link" href="personal-activo">Personal Activo</a>
                        </li>
                        <li class="nav-item {{(isset($activo) && $activo == 'tabulador')?'active':''}}" >
                            <a class="nav-link" href="tabulador">Tabulador</a>
                        </li>
                    </ul>
                </div>
            
                <a class="btn btn-outline-info my-2 my-sm-0" href="logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
            @endif
        </nav>
        @if(Auth::check() && isset($mostrar_filtro) && $mostrar_filtro)
            <form id="formulario-filtro">
                <div class="bg-info text-white" style="padding:10px;">
                    <div class="form-row">
                        <div class="col">
                            <div class="form-row">
                                @if(isset($fuentes))
                                <div class="form-group col-3">
                                    <label for="fuente_id">Fuente</label>
                                    <select id="fuente_id" name="fuente_id" class="form-control form-control-sm">
                                        <option value='' selected>Seleccione una fuente</option>
                                        @foreach($fuentes as $fuente)
                                        <option value='{{$fuente->id}}'>{{$fuente->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                @if(isset($tipos_nomina))
                                <div class="form-group col-3">
                                    <label for="tipo_nomina_id">Tipo Nomina</label>
                                    <select id="tipo_nomina_id" name="tipo_nomina_id" class="form-control form-control-sm">
                                        <option value='' selected>Seleccione un tipo de nomina</option>
                                        @foreach($tipos_nomina as $tipo_nomina)
                                        <option value='{{$tipo_nomina->id}}'>{{$tipo_nomina->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                @if(isset($programas))
                                <div class="form-group col-3">
                                    <label for="programa_id">Programa</label>
                                    <select id="programa_id" name="programa_id" class="form-control form-control-sm">
                                        <option value='' selected>Seleccione un programa</option>
                                        @foreach($programas as $programa)
                                        <option value='{{$programa->id}}'>{{$programa->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                @if(isset($puestos))
                                <div class="form-group col-3">
                                    <label for="puesto">Puesto</label>
                                    <select id="puesto" name="puesto" class="form-control form-control-sm">
                                        <option value='' selected>Seleccione un puesto</option>
                                        @foreach($puestos as $puesto)
                                        <option value='{{$puesto->codigo}}'>{{$puesto->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                @if(isset($ramas))
                                <div class="form-group col-3">
                                    <label for="rama_id">Rama</label>
                                    <select id="rama_id" name="rama_id" class="form-control form-control-sm">
                                        <option value='' selected>Seleccione una rama</option>
                                        @foreach($ramas as $rama)
                                        <option value='{{$rama->id}}'>{{$rama->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                @if(isset($profesiones))
                                <div class="form-group col-3">
                                    <label for="profesion_id">Profesión</label>
                                    <select id="profesion_id" name="profesion_id" class="form-control form-control-sm">
                                        <option value='' selected>Seleccione una profesión</option>
                                        @foreach($profesiones as $profesion)
                                        <option value='{{$profesion->id}}'>{{$profesion->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                @if(isset($mostrar_estatus))
                                <div class="form-group col-3">
                                    <label for="estatus">Estatus</label>
                                    <select id="estatus" name="estatus" class="form-control form-control-sm">
                                        <option value='' selected>Todos</option>
                                        <option value='1'>Activos</option>
                                        <option value='0'>No Activos</option>
                                    </select>
                                </div>

                                <div class="form-group col-3">
                                    <label for="sindicato">Comision Sindical</label>
                                    <select id="sindicato" name="sindicato" class="form-control form-control-sm">
                                        <option value='' selected>Todos</option>
                                        <option value='1'>Comisionado</option>
                                        <option value='0'>No Comisionado</option>
                                    </select>
                                </div>
                                @endif
                            </div>
                        </div>
                        <!--div class="form-group col-1">
                            <button type="button" class="btn btn-primary btn-block" onclick="aplicarFiltro()" style="height:100%;"><i class="fas fa-search"></i> Buscar</button>
                        </div-->
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-inline">
                                <label class="mr-2" for="fecha_inicio">Desde</label>
                                <input type="date" class="form-control form-control-sm" id="fecha_inicio" name="fecha_inicio">
                                <label class="ml-3 mr-2" for="fecha_fin">Hasta</label>
                                <input type="date" class="form-control form-control-sm" id="fecha_fin" name="fecha_fin">
                            </div>
                        </div>
                        @if(isset($mostrar_filtro_pasantes))
                        <div class="col-2">
                            <div class="form-check form-check-inline">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="mostrar_pasantes" name="mostrar_pasantes" value="1">
                                    <label class="custom-control-label" for="mostrar_pasantes">Mostrar Pasantes</label>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-2">
                            <button type="button" class="btn btn-primary btn-block" style="height:100%;" onclick="aplicarFiltro()"><i class="fas fa-search"></i> Filtrar</button>
                        </div>
                    </div>
                </div>
                @if(isset($mostrar_grupos))
                <div class="bg-dark text-white" style="padding:5px;">
                    <span>Separar los resultados por:</span>
                    <div class="form-check form-check-inline">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="group_tipo_nomina" name="group_tipo_nomina" value="1">
                            <label class="custom-control-label" for="group_tipo_nomina">Tipo Nomina</label>
                        </div>
                    </div>
                    
                    <div class="form-check form-check-inline">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="group_fuente" name="group_fuente" value="1">
                            <label class="custom-control-label" for="group_fuente">Fuente</label>
                        </div>
                    </div>
                    
                    <div class="form-check form-check-inline">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="group_programa" name="group_programa" value="1">
                            <label class="custom-control-label" for="group_programa">Programa</label>
                        </div>
                    </div>

                    @if(isset($mostrar_estatus))
                    <div class="form-check form-check-inline">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="group_rama" name="group_rama" value="1">
                            <label class="custom-control-label" for="group_rama">Rama</label>
                        </div>
                    </div>

                    <div class="form-check form-check-inline">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="group_profesion" name="group_profesion" value="1">
                            <label class="custom-control-label" for="group_profesion">Profesion</label>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </form>
        @endif
        @section('raw_content')
        @show
        <div class="container">
            @section('content')
            @show
        </div>
    </body>
</html>
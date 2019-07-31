@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('javascript')
@endsection

@section('content')
<div class="row">
    <div class="col-3">
        <img src="{{asset('images/LOGOS-01.jpg')}}" class="img-fluid" alt="Responsive image">
    </div>
    <div class="col-6">
    </div>
    <div class="col-3">
        <img src="{{asset('images/LOGOS-03.jpg')}}" class="img-fluid" alt="Responsive image">
    </div>
</div>
<hr>
<div class="row">
    <div class="offset-lg-4 col-lg-4 offset-md-3 col-md-6">
        <div class="card">
            <div class="card-header text-center">
                <h5 class="card-title">Iniciar Sesión</h5>
            </div>
            <form action="{{url('sign-in')}}" method="post">
            @csrf <!-- {{ csrf_field() }} -->
                <div class="card-body">
                    <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" class="form-control" name="username" id="username">
                        <div id="error_username" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" class="form-control" name="password" id="password">
                        <div id="error_password" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="card-footer captura-formulario">
                    <button class="btn btn-primary btn-block" type="submit">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
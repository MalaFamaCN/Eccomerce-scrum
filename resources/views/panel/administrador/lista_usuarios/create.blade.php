@extends('adminlte::page')

@section('title', 'Crear Nuevo Usuario')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <h1>Alta de Nuevo Usuario</h1>
            <a href="{{ route('user.index') }}" class="btn btn-sm btn-secondary text-uppercase">
                Volver Atras
            </a>
        </div>

        <div class="col-12">
            @include('panel.administrador.lista_usuarios.forms.form')
        </div>

    </div>
</div>
@stop

@section('css')
    
@stop

@section('js')
    
@stop
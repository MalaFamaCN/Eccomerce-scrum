@extends('adminlte::page')

@section('title', 'Crear Producto')

@section('content_header')
    
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <h1>Alta de Actualización de Precios</h1>
                <a href="{{ route('precio.index') }}" class="btn btn-sm btn-secondary text-uppercase">
                    Volver Atras
                </a>
            </div>

            <div class="col-12">
                @include('panel.administrador.lista_precios.forms.form')
            </div>
        </div>
    </div>
@stop

@section('css')
    
@stop

@section('js')
    
@stop

@extends('adminlte::page')

@section('title', 'Inicio')

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content_header')
<h1>&nbsp;<strong>Bienvenido al Panel Esmarty</strong></h1>
@stop

@section('content')
@if (auth()->user()->hasRole('cliente'))
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            {{-- <h1>Bienvenido a su Panel</h1> --}}
            <a href="{{  route('MandarDatosPaginaInicio') }}" class="btn btn-sm btn-info text-uppercase p-2">
                <i class="fas fa-shopping-cart"></i> Seguir comprando
            </a>
        </div>
    </div>
</div>
    
@endif
@stop  


@section('js')
    <script> console.log('Hi!'); </script>
@stop

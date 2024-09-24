@extends('adminlte::page')

@section('title', 'Ver')

@section('content_header')

@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <h1>Datos del Metodo de Pago "{{ $mdp->descripcion }}"</h1>
                <a href="{{ route('metodosdepago.index') }}" class="btn btn-sm btn-secondary text-uppercase">
                    Volver Atras
                </a>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            {{-- <img src="{{ $producto->url_imagen }}" alt="{{ $producto->nombre }}" id="image_preview" class="img-fluid" style="object-fit: cover; object-position: center; height: 420px; width: 100%;"> --}}
                        </div>
                        <div class="mb-3">
                            <h5><strong>Descripcion:</strong> {{ $mdp->descripcion }}</h5>
                        </div>
                        <div class="mb-3">
                            <h5><strong>Estado: </strong>@if ($mdp->activo){{"Activado"}} @else {{"Desactivado"}}@endif </h5>
                        </div>
                        {{-- <div class="mb-3">
                        <p>Creado por {{ $producto->vendedor->name }}.</p>
                    </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop

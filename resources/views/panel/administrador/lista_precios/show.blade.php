@extends('adminlte::page')

@section('title', 'Ver')

@section('content_header')
    
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <h1>Datos del Producto "{{ $producto->nombre }}"</h1>
                <a href="{{ route('precio.index') }}" class="btn btn-sm btn-secondary text-uppercase">
                    Volver Atras
                </a>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">    
                            <h5><strong>Proveedor:</strong> {{ $proveedor->descripcion }}</h5>
                        </div>
                        <div class="mb-3">
                            <h5><strong>Categoria:</strong> {{ $producto->categoria->descripcion }}</h5>
                        </div>
                        <div class="mb-3">
                            <h5><strong>Marca:</strong> {{ $producto->marca->descripcion }}</h5>
                        </div>
                        <div class="mb-3">
                            <h5><strong>Precio:</strong> {{ $producto->precio }}</h5>
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

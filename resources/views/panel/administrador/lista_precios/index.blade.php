@extends('adminlte::page')

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('title', 'Actualizar Precios')

@section('content_header')
    <h1>&nbsp;<strong>ACTUALIZAR PRECIOS</strong></h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
                <a href="{{ route('precio.create') }}" class="btn btn-success text-uppercase">
                    Actualizar Por Lote
                </a>

                <a href="{{ route('exportar-precios-pdf') }}" class="btn btn-danger" title="PDF" target="_blank">
                    <i class="fas fa-file-pdf"></i>
                </a>

                <a href="{{ route('exportar-precios-excel') }}" class="btn btn-success" title="Excel">
                    <i class="fas fa-file-excel"></i>
                </a>
            </div>

            @if (session('alert'))
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('alert') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="tabla-productos" class="table table-striped table-hover w-100">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" class="text-uppercase">Nombre</th>
                                    <th scope="col" class="text-uppercase">Proveedor</th>
                                    <th scope="col" class="text-uppercase">Categoría</th>
                                    <th scope="col" class="text-uppercase">Marca</th>
                                    <th scope="col" class="text-uppercase">Imagen</th>
                                    <th scope="col" class="text-uppercase">Precio</th>
                                    <th scope="col" class="text-uppercase text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $producto)
                                    <tr>
                                        <td>{{ $producto->codigo_producto }}</td>
                                        <td>{{ $producto->nombre }}</td>
                                        <td>{{ $producto->proveedor->descripcion }}</td>
                                        <td>{{ $producto->categoria->descripcion }}</td>
                                        <td>{{ $producto->marca ? $producto->marca->descripcion : 'N/A' }}</td>
                                        <td>
                                            @php
                                                $imagenes= explode('|', $producto->url_imagen)
                                            @endphp
                                            <img src="{{ $imagenes[0] }}" alt="{{ $producto->nombre }}" class="img-fluid" style="width: 150px;">
                                        </td>
                                        <td>${{ $producto->precio }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('precio.edit', $producto) }}" title="Editar" class="btn btn-sm btn-warning text-white text-uppercase me-1">
                                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')
    <script>
        function confirmarActualizarPrecio(event) {
            if (event.key === "Enter") {
                var confirmacion = confirm("¿Estás seguro de actualizar el precio de este producto?");

                if (confirmacion) {
                    // Puedes realizar la lógica para enviar el formulario o actualizar el precio aquí.
                    // Por ejemplo, podrías enviar un formulario usando JavaScript o AJAX.
                    // Puedes adaptar esto según tu flujo de trabajo.
                } else {
                    // Si el usuario elige "No", puedes cancelar el evento para evitar que se envíe el formulario.
                    event.preventDefault();
                }
            }
        }
    </script>

    <script src="{{ asset('js/precios.js') }}"></script>
@stop

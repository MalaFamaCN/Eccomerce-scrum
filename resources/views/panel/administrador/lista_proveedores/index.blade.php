{{-- Extiende de la plantilla de Admin LTE, nos permite tener el panel en la vista --}}
@extends('adminlte::page')

{{-- Activamos el Plugin de Datatables instalado en AdminLTE --}}
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
{{-- Titulo en las tabulaciones del Navegador --}}
@section('title', 'Proveedores')

{{-- Titulo en el contenido de la Pagina --}}
@section('content_header')
    <h1>&nbsp;<strong>PROVEEDORES</strong></h1>
@stop

{{-- Contenido de la Pagina --}}
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            
            <a href="{{ route('proveedor.create') }}" class="btn btn-success text-uppercase">
                Nuevo Proveedor 
            </a>
            <a href="{{ route('exportar-proveedor-pdf') }}" class="btn btn-danger" title="PDF" target="_blank">
                    <i class="fas fa-file-pdf"></i>
                </a>
            <a href="{{ route('exportar-proveedor-excel') }}" class="btn btn-success" title="Excel">
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
                <div class="float-right ml-5 ">
                    
                    <label for="filtroSelect">Filtrar por estado:</label>
                    <select id="filtroSelect" class="form-select" >
                        <option value="">Mostrar todos</option>
                        <option value="1">Activado</option>
                        <option value="0">Desactivado</option>
                    </select>
                    
                </div> 
                <table id="tabla-proveedores" class="table table-striped table-hover w-100">
                    <thead>
                        <tr>
                            <th scope="col" class="text-uppercase">Nombre</th>
                            <th scope="col" class="text-uppercase">CUIT</th>
                            <th scope="col" class="text-uppercase">Razon Social</th>
                            <th scope="col" class="text-uppercase">Dirección</th>
                            <th scope="col" class="text-uppercase">Telefono</th>
                            <th scope="col" class="text-uppercase">Email</th>
                            <th scope="col" class="text-uppercase">Activo</th>
                            <th scope="col" class="text-uppercase text-center">Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proveedores as $proveedor)
                        <tr>
                            <td>{{ $proveedor->descripcion }}</td>
                            <td>{{ $proveedor->cuit }}</td>
                            <td>{{ $proveedor->razon_social }}</td>
                            <td>{{ $proveedor->direccion }}</td>
                            <td>{{ $proveedor->telefono }}</td>
                            <td>{{ $proveedor->correo }}</td>
                            <td class="">
                                <form action="{{ route('producto.destroy', $proveedor) }}" method="POST">
                                    @csrf 
                                    @method('DELETE')
                                    {{-- <button type="submit" class="btn btn-sm btn-danger text-uppercase">
                                        Eliminar
                                    </button> --}}
                                    <div>
                                        <label class="switch">
                                            <input type="checkbox" class="miInterruptor" id="miInterruptor" value="{{ $proveedor->activo }}" data-change-id="{{ $proveedor->id }}">
                                            <span class="slider"><p class="estadop" style="visibility: hidden">{{ $proveedor->activo }}</p></span>
                                        </label>
                                    </div>
                                </form>
                            </td>
                            <td> 
                                <div class="d-flex justify-content-center">
                                    <a href="{{route('proveedor.show', $proveedor)}}" title="Ver" data-toggle="modal" data-target="#proveedorModal{{ $proveedor->id }}" class="btn btn-sm btn-info text-white text-uppercase me-1 mr-2">
                                        <i class="far fa-eye" aria-hidden="true"></i>
                                    </a>
                                    
                                    <a href="{{route('proveedor.edit', $proveedor)}}" title="Editar" class="btn btn-sm btn-warning text-white text-uppercase me-1">
                                        <i class="fas fa-edit" aria-hidden="true"></i>
                                    </a>
                                    {{-- <form action="{{ route('producto.destroy', $producto) }}" method="POST">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger text-uppercase">
                                            Eliminar
                                        </button>
                                    </form> --}}
                                </div>
                            </td>
                        </tr>
                        @include('panel.administrador.lista_proveedores.show')
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

{{-- Importacion de Archivos CSS --}}
@section('css')
    
@stop


{{-- Importacion de Archivos JS --}}
@section('js')

    {{-- La funcion asset() es una funcion de Laravel PHP que nos dirige a la carpeta "public" --}}
    <script src="{{ asset('js/proveedores.js') }}"></script>

    <script>
        var cambiarEstadoUrl = '{{ route('cambiar.estado.proveedor') }}';
        var token = '{{ csrf_token() }}';
    </script>

    <script src="{{ asset('js/button_switch.js') }}"></script>
@stop
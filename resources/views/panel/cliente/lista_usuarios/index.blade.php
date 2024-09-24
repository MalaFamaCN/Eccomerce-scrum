{{-- Extiende de la plantilla de Admin LTE, nos permite tener el panel en la vista --}}
@extends('adminlte::page')

{{-- Activamos el Plugin de Datatables instalado en AdminLTE --}}
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
{{-- Titulo en las tabulaciones del Navegador --}}
@section('title', 'Administrar Usuarios')

{{-- Titulo en el contenido de la Pagina --}}
@section('content_header')
    <h1>&nbsp;<strong>Administrar Usuarios</strong></h1>
@stop

{{-- Contenido de la Pagina --}}
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            
            <a href="{{ route('cliente.create') }}" class="btn btn-success text-uppercase">
                Crear Nuevo Usuario
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
                            <!-- <th scope="col">#</th> -->
                            <th scope="col" class="text-uppercase">Nombre</th>
                            <th scope="col" class="text-uppercase">Apellido</th>
                            <th scope="col" class="text-uppercase">E-mail</th>
                            <!-- <th scope="col" class="text-uppercase">DNI</th> -->
                            <!-- <th scope="col" class="text-uppercase">Telefono</th> -->
                            <th scope="col" class="text-uppercase">Rol</th>
                            <th scope="col" class="text-uppercase">Activo</th>
                            <th scope="col" class="text-uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $cliente)
                        <tr>
                        <td>{{ $cliente->name }}</td>
                        <td>{{ $cliente->apellido }}</td>
                        <td>{{ $cliente->email }}</td>
                       <!--  <td>{{ $cliente->dni }}</td> -->
                        <!-- <td>{{ $cliente->telefono }}</td> -->
                        <td>@foreach($cliente->getRoleNames() as $role)
                        {{ ucfirst($role) }}
                        @endforeach</td>
                        <td>
                            <form action="{{ route('producto.destroy', $cliente) }}" method="POST">
                                @csrf 
                                @method('DELETE')
                                {{-- <button type="submit" class="btn btn-sm btn-danger text-uppercase">
                                    Eliminar
                                </button> --}}
                                <div>
                                    <label class="switch">
                                        <input type="checkbox" class="miInterruptor" value="{{ $cliente->enabled }}" data-change-id="{{ $cliente->id }}">
                                        <span class="slider"> <p class="estadop" style="visibility: hidden">{{ $cliente->enabled }}</p></span>
                                    </label>
                                </div>
                            </form>
                        </td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('cliente.show', $cliente) }}" class="btn btn-sm btn-info text-white text-uppercase me-1 mr-2">
                                    <i class="far fa-eye" aria-hidden="true"></i>
                                </a>
                                <a href="{{ route('cliente.edit', $cliente) }}" class="btn btn-sm btn-warning text-white text-uppercase me-1">
                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                </a>
                                {{-- <form action="{{ route('cliente.destroy', $cliente) }}" method="POST">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger text-uppercase">
                                        Eliminar
                                    </button>
                                </form> --}}
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
@stop

{{-- Importacion de Archivos CSS --}}
@section('css')
    
@stop


{{-- Importacion de Archivos JS --}}
@section('js')
    <script>
    var cambiarEstadoUrl = '{{ route('cambiar.estado.users') }}';
    var token = '{{ csrf_token() }}'; 
    </script>
    <script src="{{ asset('js/button_switch.js') }}"></script>
    {{-- La funcion asset() es una funcion de Laravel PHP que nos dirige a la carpeta "public" --}}
    <script src="{{ asset('js/usuarios.js') }}"></script>
@stop
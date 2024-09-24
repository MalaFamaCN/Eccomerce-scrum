{{-- Extiende de la plantilla de Admin LTE, nos permite tener el panel en la vista --}}
@extends('adminlte::page')

{{-- Activamos el Plugin de Datatables instalado en AdminLTE --}}
@section('plugins.Datatables', true)

{{-- Titulo en las tabulaciones del Navegador --}}
@section('title', 'Historico del Stock de Productos')

{{-- Titulo en el contenido de la Pagina --}}
@section('content_header')
    <h1>&nbsp;<strong>Historico del Stock de Productos</strong></h1>
@stop

{{-- Contenido de la Pagina --}}
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            <a href="{{ route('exportar-historial-pdf') }}" class="btn btn-danger" title="PDF" target="_blank">
                <i class="fas fa-file-pdf"></i>
            </a>
        <a href="{{ route('exportar-historial-excel') }}" class="btn btn-success" title="Excel">
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
                <table id="tabla-stock" class="table table-striped table-hover w-100">
                    <thead>
                        <tr>
                            <th scope="col" class="text-uppercase">#</th>
                            <th scope="col" class="text-uppercase">Código</th>
                            <th scope="col" class="text-uppercase">Nombre</th>
                            <th scope="col" class="text-uppercase">Usuario</th>
                            <th scope="col" class="text-uppercase">Tipo Modif.</th>
                            <th scope="col" class="text-uppercase">Cant. Modif.</th>
                            <th scope="col" class="text-uppercase">Fecha</th>
                            <th scope="col" class="text-uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registros as $registro)
                        <tr>
                            <td>{{ $registro->num_registro }}</td>
                            <td>{{ $registro->producto->codigo_producto }}</td>
                            <td>{{ $registro->producto->nombre }}</td>
                            <td>{{ $registro->user->email }}</td>
                            <td >
                                <div class="d-flex justify-content-center">
                                {!!
                                    $registro->tipo_modif == 'alta' || $registro->tipo_modif == 'venta'
                                        ? '<span class="badge badge-success p-2">' . $registro->tipo_modif . '</span>'
                                        : ($registro->tipo_modif == 'ingreso'
                                        ? '<span class="badge badge-primary p-2">' . $registro->tipo_modif . '</span>'
                                        : '<span class="badge badge-danger p-2">' . $registro->tipo_modif . '</span>')
                                !!}
                                </div>
                            </td>
                            
                            
                            
                            <td><div class="d-flex justify-content-center">{{ $registro->cantidad_modif }}</div></td>
                            <td>{{ $registro->created_at }}</td>
                            <td>
                                <div title="Ver" class="d-flex justify-content-center">
                                    <a href="{{ route('stock.showDetalle', $registro) }}"  data-toggle="modal"
                                    data-target="#registroModal{{ $registro->id }}"  class="btn btn-sm btn-info text-white text-uppercase me-1 mr-2">
                                    <i class="far fa-eye"></i>
                                    </a>
                                    
                                </div>
                            </td>
                        </tr>
                        @include('panel.administrador.lista_stock.detalle')
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
    <script src="{{ asset('js/productos_stock.js') }}"></script>

    <script>
        /* $(document).ready(function () {
            $('#tabla-stock').DataTable({
                "order": [[0, "desc"]] // Esto ordena la primera columna (#) de mayor a menor
            });
        }); */
    </script>
@stop
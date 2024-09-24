{{-- Extiende de la plantilla de Admin LTE, nos permite tener el panel en la vista --}}
@extends('adminlte::page')

{{-- Activamos el Plugin de Datatables instalado en AdminLTE --}}
@section('plugins.Datatables', true)

@section('plugins.Sweetalert2', true)

{{-- Titulo en las tabulaciones del Navegador --}}
@section('title', 'Stock de Productos')

{{-- Titulo en el contenido de la Pagina --}}
@section('content_header')
    <h1>&nbsp;<strong>STOCK DE PRODUCTOS</strong></h1>
@stop

{{-- Contenido de la Pagina --}}
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            
            <a href="{{ route('stock.create') }}" class="btn btn-success text-uppercase">
                Alta Nuevo Producto 
            </a>
            <a href="{{ route('exportar-stock-pdf') }}" class="btn btn-danger" title="PDF" target="_blank">
                    <i class="fas fa-file-pdf"></i>
                </a>

                <a href="{{ route('exportar-stock-excel') }}" class="btn btn-success" title="Excel">
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
                <table id="tabla-stock" class="table table-striped table-hover w-100">
                    <thead>
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col" class="text-uppercase">Nombre</th>
                            <th scope="col" class="text-uppercase">Imagen</th>
                            {{-- <th scope="col">Proveedor</th> --}}
                            {{-- <th scope="col" class="text-uppercase">Categoría</th> --}}
                            <th scope="col" class="text-uppercase">Marca</th>
                            <th scope="col" class="text-uppercase text-center">Stock</th>
                            <th scope="col" class="text-uppercase text-center">Nivel de Stock</th>
                            <th scope="col" class="text-uppercase text-center">Activo</th>
                            <th scope="col" class="text-uppercase text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                        <tr>
                            <td>{{ $producto->codigo_producto }}</td>
                            <td>{{ $producto->nombre }}</td>
                            <td>
                                @php
                                    $imagenes= explode('|', $producto->url_imagen)
                                    @endphp
                                <img src="{{ $imagenes[0] }}" alt="{{ $producto->nombre }}" class="img-fluid" style="width: 150px;">
                            </td>
                            <td>{{ $producto->marca->descripcion }}</td>
                            <td class="text-center">{{ $producto->stock_disponible }}</td>
                            <td class="text-center justify-content-center">
                                @php
                                    if ($producto->stock_disponible == 0) {
                                        echo '<span class="badge badge-danger">SIN STOCK</span>';
                                    } else {
                                        $porcentaje = ($producto->stock_disponible / $producto->stock_deseado) * 100;
                                        $porcentajeMinimo = ($producto->stock_minimo / $producto->stock_deseado) * 100;
                                        $colorBarra = 'bg-danger'; //para cuando es 0 el %

                                        if ($porcentaje <= $porcentajeMinimo) {
                                            $colorBarra = 'bg-danger';
                                        } elseif ($porcentaje <= 40) {
                                            $colorBarra = 'bg-warning';
                                        } elseif ($porcentaje > 40 && $porcentaje <= 80) {
                                            $colorBarra = 'bg-info';
                                        } else {
                                            $colorBarra = 'bg-success';
                                        }
                                        echo '<h4><span class="badge '. $colorBarra .'" style="color: white !important;">' . round($porcentaje) . '%'.'</span></h4>';
                                    }
                                @endphp
                            </td>
                            {{-- <td>{{ $producto->stock_deseado }}</td>
                            <td>{{ $producto->stock_minimo }}</td> --}}
                            <td >
                                <form action="{{ route('producto.destroy', $producto) }}" method="POST">
                                    @csrf 
                                    @method('DELETE')
                                    {{-- <button type="submit" class="btn btn-sm btn-danger text-uppercase">
                                        Eliminar
                                    </button> --}}
                                    <div class="d-flex justify-content-center">
                                        <label class="switch">
                                            <input type="checkbox" class="miInterruptor" value="{{ $producto->activo }}" data-change-id="{{ $producto->id }}">
                                            <span class="slider"> <p class="estadop" style="visibility: hidden">{{ $producto->activo }}</p></span>
                                        </label>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a title="Ver" href="{{ route('stock.show', $producto) }}" data-toggle="modal"
                                    data-target="#productoModal{{ $producto->id }}"  class="btn btn-sm btn-info text-white text-uppercase me-1 mr-2">
                                    <i class="far fa-eye"></i>
                                    </a>
                                    
                                    <a title="Editar" href="{{ route('stock.edit', $producto) }}" class="btn btn-sm btn-warning text-white text-uppercase me-1">
                                        <i class="fas fa-edit"></i>
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
                        @include('panel.administrador.lista_stock.show')
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
    var cambiarEstadoUrl = '{{ route('cambiar.estado.producto') }}';
    var token = '{{ csrf_token() }}';
    </script>

    <script src="{{ asset('js/button_switch.js') }}"></script>
    {{-- La funcion asset() es una funcion de Laravel PHP que nos dirige a la carpeta "public" --}}
    <script src="{{ asset('js/productos_stock.js') }}"></script>
@stop
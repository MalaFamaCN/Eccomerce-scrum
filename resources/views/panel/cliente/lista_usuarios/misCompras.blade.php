{{-- Extiende de la plantilla de Admin LTE, nos permite tener el panel en la vista --}}
@extends('adminlte::page')

{{-- Activamos el Plugin de Datatables instalado en AdminLTE --}}
@section('plugins.Datatables', true)

{{-- Activamos el Plugin de Datatables instalado en AdminLTE --}}
@section('plugins.Sweetalert2', true)

{{-- Titulo en las tabulaciones del Navegador --}}
@section('title', 'Mis Compras')

{{-- Titulo en el contenido de la Pagina --}}
@section('content_header')
    <h1>&nbsp;<strong>Mis Compras</strong></h1>
@stop

{{-- Contenido de la Pagina --}}
@section('content')

    <div class="container-fluid">
        <div class="row">

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


        @if (session('error'))
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span class="text-white" aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="tabla-pedidos" class="table table-striped table-hover w-100 text-center">
                        <thead>
                            <tr>
                                <!-- <th scope="col">#</th> -->
                                <th scope="col" class="text-uppercase">N° de Pedido</th>
                                <th scope="col" class="text-uppercase">Fecha de Pedido</th>
                                <th scope="col" class="text-uppercase">Costo Total</th>
                                <th scope="col" class="text-uppercase">N° de Seguimiento</th>
                                <th scope="col" class="text-uppercase">Estado del Pedido</th>
                                <th scope="col" class="text-uppercase">Acciones</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedidos as $pedido)
                                <tr>
                                    <td>{{ $pedido->num_pedido }}</td>
                                    <td>{{ $pedido->created_at }}</td>
                                    <td>{{ $pedido->total }}</td>
                                    <td>{{ $pedido->num_seguimiento }}</td>
                                    <td>
                                        @if ($pedido->cancelado)
                                            <span class="badge badge-danger">Cancelado</span>
                                        @else
                                            @if ($pedido->pagado)
                                                <span class="badge badge-success">Pagado</span>
                                                @if ($pedido->num_seguimiento)
                                                    <span class="badge badge-primary">Enviado</span>
                                                @else
                                                     @if (!$pedido->en_preparacion)
                                                        {{-- <span class="badge badge-info">Esperando </span> --}}
                                                        @else 
                                                        @if ($pedido->en_preparacion)
                                                            <span class="badge badge-info">En preparacion</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            @else
                                                <span class="badge badge-warning text-white">Esperando Pago</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                        <a href="#"
                                            class="btn btn-sm btn-info text-white text-uppercase me-1 mr-2 cargarItems"
                                            data-toggle="modal" data-target="#showDetallePedidoModal"
                                            data-idpedido="{{ $pedido->id }}" data-num-pedido="{{ $pedido->num_pedido }}"
                                            data-nombre="{{ $pedido->nombre }}" data-apellido="{{ $pedido->apellido }}"
                                            data-email="{{ $pedido->correo }}" data-dni="{{ $pedido->dni }}"
                                            data-direccion="{{ $pedido->direccion }}"
                                            data-codigopostal="{{ $pedido->codigo_postal }}"
                                            data-telefono="{{ $pedido->telefono }}" data-total="{{ $pedido->total }}"
                                            data-cancelado="{{ $pedido->cancelado }}" data-pagado="{{ $pedido->pagado }}"
                                            data-enpreparacion="{{ $pedido->en_preparacion }}"
                                            data-enviado="{{ $pedido->enviado }}"
                                            data-urlfactura="{{ $pedido->urlFactura }}"
                                            title="Ver">
                                            <i class="far fa-eye" aria-hidden="true"></i>
                                        </a>
                                        <a href="@if (!$pedido->pagado) {{ $pedido->linkDePago }} @endif"
                                            class="btn btn-sm btn-success text-white text-uppercase me-1 mr-2 btnPagar @if ($pedido->pagado || $pedido->cancelado) d-none @endif"
                                            id="btnPagar" title="Pagar">
                                            <i class="far fa-credit-card" aria-hidden="true"></i>
                                        </a>
                                        <button
                                            class="btn btn-sm btn-danger text-white text-uppercase me-1 mr-2 @if (!$pedido->cancelado && !$pedido->pagado) btnEliminar @endif  @if ($pedido->pagado || $pedido->cancelado) d-none @endif"
                                            value="{{ $pedido->id }}" title="Cancelar">
                                            <i class="fa fa-ban" aria-hidden="true"></i>
                                        </button>
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

    @include('panel.cliente.lista_usuarios.showDetallePedido')
@stop

{{-- Importacion de Archivos CSS --}}
@section('css')

@stop


{{-- Importacion de Archivos JS --}}
@section('js')
    <script>
        let rutaParaConsulta = '{{ route('pedidos.itemsPedido', '') }}';
        let rutaParaCancelarPedido = '{{ route('pedidos.cancelarPedido', '') }}';
        var token = '{{ csrf_token() }}';
    </script>
    <script src="{{ asset('js/pedido/detalle_de_pedido.js') }}"></script>
    <script src="{{ asset('js/pedido/eliminar_pedido.js') }}"></script>
    <script src="{{ asset('js/pedido/pedidos.js') }}"></script>

@stop

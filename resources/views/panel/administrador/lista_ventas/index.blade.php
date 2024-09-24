{{-- Extiende de la plantilla de Admin LTE, nos permite tener el panel en la vista --}}
@extends('adminlte::page')

{{-- Activamos el Plugin de Datatables instalado en AdminLTE --}}
@section('plugins.Datatables', true)

{{-- Activamos el Plugin de Datatables instalado en AdminLTE --}}
@section('plugins.Sweetalert2', true)

{{-- Titulo en las tabulaciones del Navegador --}}
@section('title', 'Caja - Ventas')

{{-- Titulo en el contenido de la Pagina --}}
@section('content_header')
    <h1>&nbsp;<strong>CAJA - VENTAS</strong></h1>
@stop

{{-- Contenido de la Pagina --}}
@section('content')

    <div class="container-fluid">
        <div class="row ml-3 mb-3">
            <a href="{{ route('venta.exportarExcel') }}" class="btn btn-success" title="Excel">
                <span>Historico</span>  <i class="fas fa-file-excel ml-2"></i>
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
                        <div id="filtros" class="d-flex justify-content-between">
                        <div style="">
                            <form id="filtroFechaForm" action="{{ route('venta.ventasDiarias') }}">
                                <label for="fecha">Filtrar por Dia:</label>
                                <input type="date" id="start" name="fecha" value="{{ $fechaActual }}"
                                    min="2023-01-01" />
                            </form>
                        </div>
                        <div style="">
                            <form id="filtroMesForm" action="{{ route('venta.ventasMensuales') }}">
                                <label for="fecha">Filtrar por Mes:</label>
                                <input type="month" id="start-mes" name="fecha" value="{{ $mesActual }}"
                                    min="2023-01-01" />
                            </form>
                        </div>
                    </div>
                        <thead>
                            <tr>
                                <!-- <th scope="col">#</th> -->
                                <th scope="col" class="text-uppercase">N° de Pedido</th>
                                <th scope="col" class="text-uppercase">Fecha y Hora</th>
                                <th scope="col" class="text-uppercase">Total</th>
                                {{-- <th scope="col" class="text-uppercase">N° de Seguimiento</th> --}}
                                <th scope="col" class="text-uppercase">Estado del Pedido</th>
                                <th scope="col" class="text-uppercase">Acciones</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedidos as $pedido)
                                <tr>
                                    <td>{{ $pedido->num_pedido }}</td>
                                    <td>{{ $pedido->created_at }}</td>
                                    <td>${{ $pedido->total }}</td>
                                    {{-- <td>{{ $pedido->num_seguimiento}}</td> --}}
                                    <td>
                                        @if ($pedido->cancelado)
                                            <span class="badge badge-danger">Cancelado</span>
                                        @else
                                            @if ($pedido->pagado)
                                                <span class="badge badge-success">Pagado</span>
                                                @if ($pedido->enviado)
                                                    <span class="badge badge-primary">Enviado</span>
                                                @elseif($pedido->en_preparacion)
                                                <span class="badge badge-info">En preparacion</span>
                                                @endif
                                            @else
                                                <span class="badge badge-warning text-white">Esperando Pago</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td><a href="#"
                                            title="Ver"
                                            class="btn btn-sm btn-info text-white text-uppercase me-1 mr-2 cargarItems"
                                            data-toggle="modal" data-target="#showDetallePedidoModal"
                                            data-idpedido="{{ $pedido->id }}"
                                            data-num-pedido="{{ $pedido->num_pedido }}"
                                            data-nombre="{{ $pedido->nombre }}" data-apellido="{{ $pedido->apellido }}"
                                            data-email="{{ $pedido->correo }}" data-dni="{{ $pedido->dni }}"
                                            data-direccion="{{ $pedido->direccion }}"
                                            data-codigopostal="{{ $pedido->codigo_postal }}"
                                            data-telefono="{{ $pedido->telefono }}" data-total="{{ $pedido->total }}"
                                            data-cancelado="{{ $pedido->cancelado }}" data-pagado="{{ $pedido->pagado }}"
                                            data-enpreparacion="{{ $pedido->en_preparacion }}"
                                            data-enviado="{{ $pedido->enviado }}"
                                            data-urlfactura="{{ $pedido->urlFactura }}">
                                            <i class="far fa-eye" aria-hidden="true"></i>
                                        </a>

                                        <button
                                            class="btn btn-sm btn-danger text-white text-uppercase me-1 mr-2 @if (!$pedido->cancelado && !$pedido->pagado) btnEliminar @endif  @if ($pedido->pagado || $pedido->cancelado) d-none @endif"
                                            value="{{ $pedido->id }}">
                                            Cancelar
                                        </button>
                                        <a href="@if (!$pedido->pagado) {{ $pedido->linkDePago }} @endif"
                                            class="btn btn-sm btn-success text-white text-uppercase me-1 mr-2 btnPagar @if ($pedido->pagado || $pedido->cancelado) d-none @endif"
                                            id="btnPagar">
                                            Pagar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                        
                    </table>
                    <div class="border p-2 text-right float-right" style="font-size: 1.2rem; justify-content: space-between!important">
                        <span class=""> <b> Total Caja:</b> ${{ $totalCaja }} </span>
                    </div>
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
        $(document).ready(function() {
            // Captura el cambio en el input de fecha
            $('#start').on('change', function() {
                // Obtiene la fecha seleccionada
                var fechaSeleccionada = $(this).val();

                // Obtiene la URL base del formulario
                var urlBase = $('#filtroFechaForm').attr('action');

                // Construye la URL completa con la fecha seleccionada
                var urlCompleta = urlBase + '?fecha=' + fechaSeleccionada;

                // Redirige a la nueva URL
                window.location.href = urlCompleta;
            });
        });

        $(document).ready(function() {
            // Captura el cambio en el input de fecha
            $('#start-mes').on('change', function() {
                // Obtiene la fecha seleccionada
                var fechaSeleccionada = $(this).val();

                // Obtiene la URL base del formulario
                var urlBase = $('#filtroMesForm').attr('action');

                // Construye la URL completa con la fecha seleccionada
                var urlCompleta = urlBase + '?fecha=' + fechaSeleccionada;

                // Redirige a la nueva URL
                window.location.href = urlCompleta;
            });
        });
    </script>

    <script>
        let rutaParaConsulta = '{{ route('pedidos.itemsPedido', '') }}';
        let rutaParaCancelarPedido = '{{ route('pedidos.cancelarPedido', '') }}';
        var token = '{{ csrf_token() }}';
    </script>

    {{-- Datatables --}}
    <script src="{{ asset('js/pedido/detalle_de_pedido.js') }}"></script>
    <script src="{{ asset('js/pedido/eliminar_pedido.js') }}"></script>
    <script src="{{ asset('js/ventas.js') }}"></script>

@stop

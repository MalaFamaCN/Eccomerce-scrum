{{-- Extiende de la plantilla de Admin LTE, nos permite tener el panel en la vista --}}
@extends('adminlte::page')

{{-- Activamos el Plugin de Datatables instalado en AdminLTE --}}
@section('plugins.Datatables', true)

{{-- Activamos el Plugin de Datatables instalado en AdminLTE --}}
@section('plugins.Sweetalert2', true)

{{-- Titulo en las tabulaciones del Navegador --}}
@section('title', 'Pedidos')

{{-- Titulo en el contenido de la Pagina --}}
@section('content_header')
    <h1>&nbsp;<strong>Pedidos en Preparacion</strong></h1>
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
                                <th scope="col" class="text-uppercase">Fecha de Pago</th>
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
                                    <td>{{ $pedido->updated_at }}</td>
                                    <td>{{ $pedido->total }}</td>

                                    <td>
                                        <form class="d-flex" method="POST"
                                            action="{{ route('guardarNumero', ['id' => $pedido->id]) }}">
                                            @csrf
                                            <input type="number" name="numero"
                                                {{ $pedido->en_preparacion ? '' : 'disabled' }}
                                                onkeypress="return event.keyCode != 13;">
                                            @if ($pedido->en_preparacion)
                                                <button type="submit" class="checkButton">✔</button>
                                            @else
                                                <button disabled class="checkButton">✔</button>
                                            @endif
                                        </form>
                                    </td>

                                    <td>
                                        @if ($pedido->num_seguimiento)
                                            <span class="badge badge-primary">Enviado</span>
                                        @else
                                            @if ($pedido->en_preparacion)
                                                <span class="badge badge-info">En preparacion</span>
                                            @else
                                                @if ($pedido)
                                                    <span class="badge badge-warning text-white">Pendiente</span>
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="#" title="Ver"
                                                class="btn btn-sm btn-info text-white text-uppercase me-1 mr-2 cargarItems"
                                                data-toggle="modal" data-target="#showDetallePedidoModal"
                                                data-idpedido="{{ $pedido->id }}"
                                                data-num-pedido="{{ $pedido->num_pedido }}"
                                                data-nombre="{{ $pedido->nombre }}"
                                                data-apellido="{{ $pedido->apellido }}" data-email="{{ $pedido->correo }}"
                                                data-dni="{{ $pedido->dni }}" data-direccion="{{ $pedido->direccion }}"
                                                data-codigopostal="{{ $pedido->codigo_postal }}"
                                                data-telefono="{{ $pedido->telefono }}" data-total="{{ $pedido->total }}"
                                                data-cancelado="{{ $pedido->cancelado }}"
                                                data-pagado="{{ $pedido->pagado }}"
                                                data-enpreparacion="{{ $pedido->en_preparacion }}"
                                                data-enviado="{{ $pedido->enviado }}"
                                                data-urlfactura="{{ $pedido->urlFactura }}">
                                                <i class="far fa-eye"></i>
                                            </a>

                                            @if (!$pedido->en_preparacion)
                                                <button title="Preparar"
                                                    class="btn btn-sm btn-success text-white text-uppercase prepararNumSeguimiento"
                                                    data-route="{{ route('prepararPedido', ['id' => $pedido->id]) }}"
                                                    onclick=""><i class="fas fa-box"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-success text-white text-uppercase " disabled>
                                                    <i class="fas fa-box"></i>
                                                </button>
                                            @endif
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
    <script src="{{ asset('js/pedido/pedidosPreparar.js') }}"></script>
    <script src="{{ asset('js/pedido/num_seguimiento.js') }}"></script>
    <script src="{{ asset('js/pedido/recargarPagina.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.prepararNumSeguimiento').click(function() {
                console.log("Clic detectado");
                var route = $(this).data('route');
                var inputId = $(this).closest('tr').find('input[name="numero"]').attr('id');
                Swal.fire({
                    title: "¿Quiere preparar este pedido?",
                    type: 'question',
                    // text: "You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si",
                    cancelButtonText: "No",
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.value) {
                        window.location.href = route;
                    }
                });

            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var form = document.querySelectorAll("form.d-flex");

            form.forEach(function(currentForm) {
                var input = currentForm.querySelector("input[name='numero']");

                currentForm.addEventListener("submit", function(event) {
                    if (input.value.trim() === "" || input.value.length > 15) {
                        event.preventDefault();

                        Swal.fire({
                            type: 'warning',
                            title: 'Error',
                            text: 'El campo debe tener contenido y no puede exceder los 15 caracteres.',
                        });
                    }
                });

                input.addEventListener("keydown", function(event) {
                    if (event.key === "Enter") {
                        if (input.value.trim() === "" || input.value.length > 15) {
                            event.preventDefault();
                            event.stopPropagation(); // Evitar la propagación del evento submit

                            Swal.fire({
                                type: 'warning',
                                title: 'Error',
                                text: 'El campo debe tener contenido y no puede exceder los 15 caracteres.',
                            });
                        }
                    }
                });
            });
        });
    </script>
@stop

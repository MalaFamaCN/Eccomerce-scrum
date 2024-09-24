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
    <h1>&nbsp;<strong>Pedidos Enviados</strong></h1>
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
                                            <input type="number" value="{{ $pedido->num_seguimiento }}" name="numero"
                                                id="num_seguimiento_{{ $pedido->id }}" disabled
                                                onkeypress="return event.keyCode != 13;"> <button disabled
                                                class="checkButton">✔</button>
                                        </form>
                                    </td>
                                    <td><span class="badge badge-primary">Enviado</span></td>


                                    <td>
                                        <div class="d-flex justify-content-center">
                                        <a href="#"
                                        title="Ver"
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
                                            data-urlfactura="{{ $pedido->urlFactura }}">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <button title="Editar"
                                            class="btn btn-sm btn-warning text-white text-uppercase editarNumSeguimiento"><i class="fas fa-edit"></i></button>
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
    <script>
        $(document).ready(function() {
            $('.editarNumSeguimiento').click(function() {
                console.log("Clic detectado"); 
                var inputId = $(this).closest('tr').find('input[name="numero"]').attr('id');
                var checkButton = $(this).closest('tr').find('.checkButton');
                
                Swal.fire({
                    title: "¿Estás seguro de querer editar?",
                    type: 'question',
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí",
                    cancelButtonText: "No",
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.value) {
                        $('#' + inputId).prop('disabled', function(i, val) {
                            return !val;
                        });
                        checkButton.prop('disabled', function(i, val) {
                            return !val;
                        });

                        // Validamos antes de enviar el formulario
                        $('#' + inputId).closest('form').submit(function(e) {
                            if ($('#' + inputId).val().trim() === '' || $('#' + inputId).val().length > 15) {
                                e.preventDefault();
                                Swal.fire({
                                    type: 'warning',
                                    title: 'Error',
                                    text: 'El campo debe tener contenido y no puede exceder los 15 caracteres.',
                                });
                            }
                        });

                        // Si no hay nada o es mayor a 15 los caracteres se cancela el envio
                        $('#' + inputId).on('keydown', function(e) {
                            if (e.key === 'Enter') {
                                e.preventDefault();
                                if ($('#' + inputId).val().trim() === '' || $('#' + inputId).val().length > 15) {
                                    Swal.fire({
                                        type: 'warning',
                                        title: 'Error',
                                        text: 'El campo debe tener contenido y no puede exceder los 15 caracteres.',
                                    });
                                } else {
                                    $('#' + inputId).closest('form').submit();
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>

@stop

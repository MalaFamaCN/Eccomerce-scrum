@extends('frontend.layouts.master')
@section('title', 'Esmarty || Detalles del Producto')
@section('main-content')
    <link rel="stylesheet" href="{{ asset('css/detalleProducto.css') }}">

    @php
        $imagen = explode('|', $producto->url_imagen);

    @endphp
    <div class = "container py-4">
        <div class = "card add-shadow p-4">
            <!-- Card Izquierda -->
            <div class = "product-imgs">
                {{-- Breadcrumbs --}}
                <div class="container-fluid pt-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><i class='bx bxs-folder-open'></i></li>
                            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('productos') }}">Productos</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detalles del Producto</li>
                        </ol>
                    </nav>
                </div>
                {{-- Breadcrumbs Fin --}}
                <div class = "img-display">
                    <div class = "img-showcase">
                        <img class="imagen" src = "{{ $imagen[0] }}" alt = "imagen-producto">
                        <img class="imagen" src = "{{ isset($imagen[1]) ? $imagen[1] : '' }}" alt = "imagen-producto">
                        <img class="imagen" src = "{{ isset($imagen[2]) ? $imagen[2] : '' }}" alt = "imagen-producto">
                    </div>
                </div>
                <div class = "img-select">
                    <div class = "img-item add-shadow p-2">
                        <a href = "#" data-id = "1">
                            <img src = "{{ $imagen[0] }}" alt = "{{ $imagen[0] }}">
                        </a>
                    </div>
                    <div class = "img-item add-shadow p-2">
                        <a href = "#" data-id = "2">
                            <img src = "{{ isset($imagen[1]) ? $imagen[1] : '' }}"
                                alt = "{{ isset($imagen[1]) ? $imagen[1] : '' }}">
                        </a>
                    </div>
                    <div class = "img-item add-shadow p-2">
                        <a href = "#" data-id = "3">
                            <img src = "{{ isset($imagen[2]) ? $imagen[2] : '' }}"
                                alt = "{{ isset($imagen[2]) ? $imagen[2] : '' }}">
                        </a>
                    </div>
                </div>
            </div>
            {{-- End Card Izquierda --}}
            <!-- Card Derecha-->
            <div class = "product-content mt-3">
                {{-- Detalle Info --}}
                <link rel="stylesheet" href="{{ asset('css/detalleProducto.css') }}">
                <h2 class ="text-title product-title"> {{ $producto->nombre }} </h2>
                <a href="{{ route('MandarDatosCategoriaEspecifica', ['categoria' => $categoriaEspecifica->id]) }}"
                    class="badge-category badge text-bg-secondary"> {{ $categoriaEspecifica->descripcion }} </a>
               {!! $producto->stock_disponible > 3 ? "<p class='badge-category badge text-bg-warning'> Últimos Disponibles </p>" :
                ($producto->stock_disponible > 0 ? "<p class='badge-category badge text-bg-success'> Stock Disponible </p>" : "<p class='badge-category badge text-bg-danger'> Sin Stock </p>") !!}</p>

                <div class="product-price">
                    <div class="row">
                        <div class="col-md-3 precio-estilo">
                            <h2><span>${{ $producto->precio }} </span></h3>
                        </div>
                        <div class="col-md-5">
                            <button href="#" data-agregar-id="{{ $producto->id }}"
                                class="btn btn-sm mb-3 color-enfasis btn-enfasis rounded-pill text-white text-uppercase agregarAlCarrito add-shadow">
                                AGREGAR AL CARRITO
                            </button>
                        </div>
                    </div>

                </div>
                <hr>
                <div class="product-detail">
                    <div class="container element-box p-4">
                        <h3>Descripción:</h3>
                        <p>{{ $producto->descripcion }}</p>
                        <span class="badge-category badge text-bg-light"> Marca {{ $producto->marca->descripcion }}</span>
                    </div>
                </div>
                <!-- End card derecha -->
            </div>
        </div>
    </div>
    {{-- End Detalle Info --}}

@endsection
@section('js')
    <script src="{{ asset('js/slider-producto.js') }}"></script>

    <script>
        let rutaParaAgregar = '{{ route('carrito.agregarAlCarrito') }}';
        var token = '{{ csrf_token() }}';
        let clienteId = {{ Auth::id() ? Auth::id() : 0 }}
    </script>
@endsection

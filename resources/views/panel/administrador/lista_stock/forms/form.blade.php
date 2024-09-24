<div class="card mb-5">
    <form action="{{ $producto->id ? route('stock.update', $producto) : route('stock.store') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @if ($producto->id)
            @method('PUT')
        @endif

        <div class="card-body">

            @if ($producto->id)
            <div class="mb-3" id="imagePreviewDefault">
                @foreach ($imagenes as $imagen)
                <img src="{{ $imagen }}" alt="{{ $producto->nombre }}" id="image_preview" class="img-fluid" style="object-fit: contain; object-position: center; height: 250px; width: 250px;">    
                @endforeach
            </div>    
            @endif

            <div class="mb-3 row">
                <label for="codigo_producto" class="col-sm-4 col-form-label"> * Código </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control @error('codigo_producto') is-invalid @enderror" {{ $producto->id ? 'readonly' : '' }}
                        id="codigo_producto" name="codigo_producto" placeholder="código correspondiente al producto"
                        value="{{ old('codigo_producto', optional($producto)->codigo_producto) }}" maxlength="15" required>
                    @error('codigo_producto')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <label for="nombre" class="col-sm-4 col-form-label"> * Nombre </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                        name="nombre" placeholder="nombre del producto" {{ $producto->id ? 'readonly' : '' }}
                        value="{{ old('nombre', optional($producto)->nombre) }}" maxlength="120" required>
                    @error('nombre')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <label for="proveedor" class="col-sm-4 col-form-label"> * Proveedor </label>
                <div class="col-sm-8">
                    @if ($producto->id)
                    <div class="mb-3 row">
                        <div class="col-sm-8">
                            <input type="text" id="id_proveedor" name="id_proveedor" class="form-control" value="{{ $producto->proveedor->descripcion }}" {{ $producto->id ? 'readonly' : '' }}>
                        </div>
                    </div>
                    @else
                    <select id="id_proveedor" name="id_proveedor" class="form-control @error('id_proveedor') is-invalid @enderror">
                        <option disabled selected>---- seleccione un proveedor ----</option>
                        @foreach ($proveedores as $proveedor)
                        @if($proveedor->activo == 1)
                            <option {{$producto->id_proveedor && $producto->id_proveedor == $proveedor->id ? 'selected': ''}} value="{{ $proveedor->id }}"> 
                                {{ $proveedor->descripcion }}
                            </option>
                        @endif    
                        @endforeach 
                    </select>
                    @error('id_proveedor')
                    <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror 
                    @endif
                </div>
            </div>
            
            <div class="mb-3 row">
                <label for="marca" class="col-sm-4 col-form-label"> * Marca </label>
                @if ($producto->id)
                <div class="col-sm-8">
                    <input type="text" id="id_marca" name="id_marca" class="form-control" value="{{ $producto->marca->descripcion }}" {{ $producto->id ? 'readonly' : '' }}>
                </div>
                @else
                <div class="col-sm-8">
                    <select id="id_marca" name="id_marca" class="form-control @error('id_marca') is-invalid @enderror">
                        <option disabled selected>---- seleccione una marca ----</option>
                        @foreach ($marcas as $marca)
                        @if($marca->activo == 1)
                            <option {{$producto->id_marca && $producto->id_marca == $marca->id ? 'selected' : '' }}
                                value="{{ $marca->id }}">
                                {{ $marca->descripcion }}
                            </option>
                        @endif
                        @endforeach
                    </select>
                    @error('id_marca')
                    <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
                @endif
            </div>
            
            <div class="mb-3 row">
                <label for="stock_disponible" class="col-sm-4 col-form-label"> {{ !isset($producto->id) ? '* Stock Inicial' : '* Stock Disponible' }} </label>
                <div class="col-sm-3">
                    <input type="number" class="form-control @error('stock_disponible') is-invalid @enderror" {{ $producto->id ? 'readonly' : '' }}
                        id="stock_disponible" name="stock_disponible" placeholder="cantidad disponible actualmente"
                        value="{{ old('stock_disponible', optional($producto)->stock_disponible) }}" maxlength="3" required>
                    @error('stock_disponible')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
            </div>
            
            @role('admin')
            <div class="mb-3 row">
                <label for="stock_deseado" class="col-sm-4 col-form-label"> * Stock Deseado </label>
                <div class="col-sm-3">
                    <input type="number" class="form-control @error('stock_deseado') is-invalid @enderror"
                        id="stock_deseado" name="stock_deseado" placeholder="cantidad deseada" @unlessrole('admin'){{ $producto->id ? 'readonly' : '' }}@endunlessrole
                        value="{{ old('stock_deseado', optional($producto)->stock_deseado) }}" maxlength="3">
                    @error('stock_deseado')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
            </div>
            @endrole

            @role('admin')
            <div class="mb-3 row">
                <label for="stock_minimo" class="col-sm-4 col-form-label"> * Stock Minimo </label>
                <div class="col-sm-3">
                    <input type="number" class="form-control @error('stock_minimo') is-invalid @enderror"
                        id="stock_minimo" name="stock_minimo" placeholder="cantidad mínima" @unlessrole('admin'){{ $producto->id ? 'readonly' : '' }}@endunlessrole
                        value="{{ old('stock_minimo', optional($producto)->stock_minimo) }}" maxlength="3">
                    @error('stock_minimo')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
            </div>
            @endrole
            
            @if ($producto->id)
            <div class="mb-3 row">

                <label for="tipo_modif" class="col-sm-4 col-form-label"> * Tipo de Modificación </label>
                <div class="col-sm-2">
                    <select id="tipo_modif" name="tipo_modif" class="form-control @error('tipo_modif') is-invalid @enderror">
                        <option disabled selected>---- seleccione una opción ----</option>
                        <option value="ingreso"> Ingreso </option>
                        <option value="egreso"> Egreso </option>
                        <option value="devolucion"> Devolución </option>
                    </select>
                    @error('tipo_modif')
                    <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>

                <label for="cantidad_modif" class="col-sm-1 col-form-label"> * Cantidad </label>
                <div class="col-sm-2">
                    <input type="number" class="form-control @error('cantidad_modif') is-invalid @enderror"
                        id="cantidad_modif" name="cantidad_modif" placeholder="cantidad que modifica"
                        value="" maxlength="3" readonly>
                    @error('cantidad_modif')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                    <span id="cantidad_modif-error" class="invalid-feedback text-danger"></span>
                </div>
                
            </div>

            <div class="mb-3 row">
                <label for="motivo_modif" class="col-sm-4 col-form-label"> * Motivo de la Modificación </label>
                <div class="col-sm-8">
                    <textarea id="motivo_modif" name="motivo_modif" rows="4" class="form-control @error('motivo_modif') is-invalid @enderror" minlength="20" maxlength="200"
                    placeholder="Explique brevemente el motivo de la modificación..." readonly>{{ old('motivo_modif', optional($producto)->motivo_modif) }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                    <span id="motivo_modif-error" class="invalid-feedback text-danger"></span>
                </div>
            </div>
            @endif

        </div> {{-- CIERRE --}}

        <div class="card-footer">
            <button type="submit" class="btn btn-success text-uppercase">
                {{ $producto->id ? 'Actualizar' : 'Guardar' }}
            </button>
        </div>
    </form>
</div>


@section('js')

{{-- <script>
    $(document).ready(function () {
        // Agrega el evento change para el campo tipo_modif
        $('#tipo_modif').on('change', function () {
            validateTipoModif();
            updateSubmitButton();
        });

        // Agrega el evento input para los campos relacionados
        $('#cantidad_modif, #stock_disponible').on('input', function () {
            validateCantidadModif();
            updateSubmitButton();
        });

        function validateCantidadModif() {
            var tipoModif = $('#tipo_modif').val();
            var cantidadModif = parseFloat($('#cantidad_modif').val()) || 0;
            var stockDisponible = parseFloat($('#stock_disponible').val()) || 0;
            var errorMessage = '';

            // Validación: cantidad_modif no debe ser negativo
            if (cantidadModif < 0) {
                errorMessage = 'La cantidad no puede ser negativa.';
            }

            // Validación: Si es egreso o devolución, cantidad_modif no debe ser mayor a stock_disponible
            if ((tipoModif === 'egreso' || tipoModif === 'devolucion') && cantidadModif > stockDisponible) {
                errorMessage = 'La cantidad no puede ser mayor al stock disponible.';
            }

            // Muestra el mensaje de error o limpia el mensaje si no hay error
            $('#cantidad_modif').toggleClass('is-invalid', errorMessage !== '');
            $('#cantidad_modif-error').text(errorMessage);
        }

        function validateTipoModif() {
            var tipoModif = $('#tipo_modif').val();

            // Cambia el atributo readonly de los campos cantidad_modif y motivo_modif según la selección
            $('#cantidad_modif, #motivo_modif').prop('readonly', tipoModif === '');

            // Si el tipoModif es '', también limpia el valor de cantidad_modif
            if (tipoModif === '') {
                $('#cantidad_modif').val('');
            }
        }

        function updateSubmitButton() {
            // Habilita o deshabilita el botón de enviar según si hay errores o no
            $('button[type="submit"]').prop('disabled', $('#cantidad_modif').hasClass('is-invalid'));
        }
    });
</script> --}}

<script src="{{ asset('js/stock_update_validation.js') }}"></script>

@stop
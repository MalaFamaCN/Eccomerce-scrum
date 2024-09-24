<div class="container mt-5">
    <div class="row">

        <!-- Proveedor Card -->
        <div class="col-4">
    <div class="card mb-4">
        <form action="{{ $producto->id ? route('precio.actualizarProveedor', $producto) : route('precio.actualizarProveedor') }}" method="POST" enctype="multipart/form-data" id="proveedor">
            @csrf
            @if ($producto->id)
                @method('PUT')
            @endif

            <div class="card-body">
                <div class="mb-3 row">
                    <label for="proveedor" class="col-sm-4 col-form-label"> * Proveedor </label>
                    <div class="col-sm-8">
                        <select id="id_proveedor" name="id_proveedor" class="form-control @error('id_proveedor') is-invalid @enderror">
                            <option disabled selected>Seleccione un Proveedor</option>
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
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="precio" class="col-sm-4 col-form-label"> * Precio </label>
                    <div class="col-sm-8">
                        <input type="range" id="precioProveedor" name="precioProveedor" min="1" max="100" />
                        <span id="porcentajeValorProveedor">50 %</span>
                        @error('precio')
                            <div class="invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="operacion" class="col-sm-4 col-form-label"> Operación </label>
                    <div class="col-sm-8">
                        <div class="form-check">
                            <input class="form-check-input operacion-checkbox" type="radio" id="disminuir" name="operacion" value="disminuir">
                            <label class="form-check-label" for="disminuir">
                                Disminuir
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input operacion-checkbox" type="radio" id="aumentar" name="operacion" value="aumentar">
                            <label class="form-check-label" for="aumentar">
                                Aumentar
                            </label>
                        </div>
                        <div class="invalid-feedback" id="operacionError">Selecciona al menos un checkbox.</div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success text-uppercase guardar-btn" data-target="id_proveedor">
                    {{ $producto->id ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>
        </form>
    </div>
</div>


        <!-- Categoria Card -->
        <div class="col-4">
            <div class="card mb-4">
                <form action="{{ $producto->id ? route('precio.actualizarCategoria', $producto) : route('precio.actualizarCategoria') }}" method="POST" enctype="multipart/form-data" id="categoria">
                    @csrf
                    @if ($producto->id)
                        @method('PUT')
                    @endif

                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="id_categoria" class="col-sm-4 col-form-label"> * Categoria </label>
                            <div class="col-sm-8">
                                <select id="id_categoria" name="id_categoria" class="form-control @error('id_categoria') is-invalid @enderror">
                                    <option disabled selected>Seleccione una Categoría</option>
                                    @foreach ($categorias as $categoria)
                                        @if($categoria->activo == 1)
                                            <option {{ $producto->id_categoria && $producto->id_categoria == $categoria->id ? 'selected' : '' }} value="{{ $categoria->id }}">
                                                {{ $categoria->descripcion }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('id_categoria')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="precio" class="col-sm-4 col-form-label"> * Precio </label>
                            <div class="col-sm-8">
                                <input type="range" id="precioCategoria" name="precioCategoria" min="1" max="100" />
                                <span id="porcentajeValorCategoria">50 %</span>
                                @error('precio')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="operacion" class="col-sm-4 col-form-label"> Operación </label>
                            <div class="col-sm-8">
                                <div class="form-check">
                                    <input class="form-check-input operacion-checkbox" type="radio" id="disminuirCategoria" name="operacion" value="disminuir">
                                    <label class="form-check-label" for="disminuirCategoria">
                                        Disminuir
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input operacion-checkbox" type="radio" id="aumentarCategoria" name="operacion" value="aumentar">
                                    <label class="form-check-label" for="aumentarCategoria">
                                        Aumentar
                                    </label>
                                </div>
                                <div class="invalid-feedback" id="operacionError2">Selecciona al menos un checkbox.</div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success text-uppercase guardar-btn" data-target="id_categoria">
                            {{ $producto->id ? 'Actualizar' : 'Guardar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Marca Card -->
        <div class="col-4">
            <div class="card mb-4">
                <form action="{{ $producto->id ? route('precio.actualizarMarca', $producto) : route('precio.actualizarMarca') }}" method="POST" enctype="multipart/form-data" id="marca">
                    @csrf
                    @if ($producto->id)
                        @method('PUT')
                    @endif

                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="id_marca" class="col-sm-4 col-form-label"> * Marca </label>
                            <div class="col-sm-8">
                                <select id="id_marca" name="id_marca" class="form-control @error('id_marca') is-invalid @enderror">
                                    <option disabled selected>Seleccione una Marca</option>
                                    @foreach ($marcas as $marca)
                                        @if($marca->activo == 1)
                                            <option {{$producto->id_marca && $producto->id_marca == $marca->id ? 'selected' : '' }} value="{{ $marca->id }}">
                                                {{ $marca->descripcion }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('id_marca')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="precio" class="col-sm-4 col-form-label"> * Precio </label>
                            <div class="col-sm-8">
                                <input type="range" id="precioMarca" name="precioMarca" min="1" max="100" />
                                <span id="porcentajeValorMarca">50 %</span>
                                @error('precio')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="operacion" class="col-sm-4 col-form-label"> Operación </label>
                            <div class="col-sm-8">
                                <div class="form-check">
                                    <input class="form-check-input operacion-checkbox" type="radio" id="disminuirMarca" name="operacion" value="disminuir">
                                    <label class="form-check-label" for="disminuirMarca">
                                        Disminuir
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input operacion-checkbox" type="radio" id="aumentarMarca" name="operacion" value="aumentar">
                                    <label class="form-check-label" for="aumentarMarca">
                                        Aumentar
                                    </label>
                                </div>
                                <div class="invalid-feedback" id="operacionError3">Selecciona al menos un checkbox.</div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success text-uppercase guardar-btn" data-target="id_marca">
                            {{ $producto->id ? 'Actualizar' : 'Guardar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
<script> //este script permite que funcione los checkbox y el range
   document.addEventListener("DOMContentLoaded", function () {
        var rangeProveedor = document.getElementById("precioProveedor");
        var porcentajeValorProveedor = document.getElementById("porcentajeValorProveedor");
        var operacionCheckboxes = document.querySelectorAll(".operacion-checkbox");

        rangeProveedor.addEventListener("input", function () {
            var porcentaje = rangeProveedor.value;
            porcentajeValorProveedor.textContent = porcentaje + " %";
        });

        function handleOperacionChange() {
            var operacionCheckbox = document.querySelector(".operacion-checkbox:checked");
            if (operacionCheckbox) {
                var operacionValue = operacionCheckbox.value;
                if (operacionValue === "aumentar") {
                    rangeProveedor.value = parseInt(rangeProveedor.value) + 10; // Aumenta en 10 unidades, por ejemplo
                } else if (operacionValue === "disminuir") {
                    rangeProveedor.value = parseInt(rangeProveedor.value) - 10; // Disminuye en 10 unidades, por ejemplo
                }
                porcentajeValorProveedor.textContent = rangeProveedor.value + " %";
            }
        }

        operacionCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener("change", handleOperacionChange);
        });
    });
        
        
        //categoria
        document.addEventListener("DOMContentLoaded", function () {
        var rangeCategoria = document.getElementById("precioCategoria");
        var porcentajeValorCategoria = document.getElementById("porcentajeValorCategoria");
        var operacionCheckboxes = document.querySelectorAll(".operacion-checkbox");

        rangeCategoria.addEventListener("input", function () {
            var porcentaje = rangeCategoria.value;
            porcentajeValorCategoria.textContent = porcentaje + " %";
        });

        function handleOperacionChange() {
            var operacionCheckbox = document.querySelector(".operacion-checkbox:checked");
            if (operacionCheckbox) {
                var operacionValue = operacionCheckbox.value;
                if (operacionValue === "aumentar") {
                    rangeCategoria.value = parseInt(rangeCategoria.value) + 10; // Aumenta en 10 unidades, por ejemplo
                } else if (operacionValue === "disminuir") {
                    rangeCategoria.value = parseInt(rangeCategoria.value) - 10; // Disminuye en 10 unidades, por ejemplo
                }
                porcentajeValorCategoria.textContent = rangeCategoria.value + " %";
            }
        }

        operacionCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener("change", handleOperacionChange);
        });
    });

    //marca
    document.addEventListener("DOMContentLoaded", function () {
        var rangeMarca = document.getElementById("precioMarca");
        var porcentajeValorMarca = document.getElementById("porcentajeValorMarca");
        var operacionCheckboxes = document.querySelectorAll(".operacion-checkbox");

        rangeMarca.addEventListener("input", function () {
            var porcentaje = rangeMarca.value;
            porcentajeValorMarca.textContent = porcentaje + " %";
        });

        function handleOperacionChange() {
            var operacionCheckbox = document.querySelector(".operacion-checkbox:checked");
            if (operacionCheckbox) {
                var operacionValue = operacionCheckbox.value;
                if (operacionValue === "aumentar") {
                    rangeMarca.value = parseInt(rangeMarca.value) + 10; // Aumenta en 10 unidades, por ejemplo
                } else if (operacionValue === "disminuir") {
                    rangeMarca.value = parseInt(rangeMarca.value) - 10; // Disminuye en 10 unidades, por ejemplo
                }
                porcentajeValorMarca.textContent = rangeMarca.value + " %";
            }
        }

        operacionCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener("change", handleOperacionChange);
        });
    });
    
</script>



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $('.guardar-btn').click(function() {
            // Obtiene el data-target del botón presionado
            var campoId = $(this).data('target');
            
            // Llama a la función de validación para el campo específico
            if (!validarCampo(campoId, 'Por favor, seleccione un ' + campoId + ' antes de guardar.')) {
                // Detiene el evento si la validación falla
                return false;
            }
        });

        // Función de validación genérica
        function validarCampo(campoId, mensajeError) {
            var valorCampo = $('#' + campoId).val();

            // Valida si el campo está vacío
            if (valorCampo === null || valorCampo === undefined || valorCampo === "") {
                // Muestra un mensaje de error debajo del input
                $('#' + campoId).addClass('is-invalid'); // Agrega la clase is-invalid al input
                $('#' + campoId + ' + .invalid-feedback').text(mensajeError); // Muestra el mensaje de error
                return false; // Devuelve false indicando que la validación ha fallado
            }

            return true; // Devuelve true indicando que la validación ha pasado
        }
    });
</script>


<script> //validacion proveedor
    document.addEventListener("DOMContentLoaded", function () {
        var form = document.getElementById("proveedor");
        var operacionError = document.getElementById("operacionError");

        form.addEventListener("submit", function (event) {
            var checkboxes = form.querySelectorAll(".operacion-checkbox");
            var checkboxSeleccionado = Array.from(checkboxes).some(function (checkbox) {
                return checkbox.checked;
            });

            if (!checkboxSeleccionado) {
                // Si ningún checkbox está seleccionado, muestra el mensaje de error
                operacionError.style.display = "block";
                event.preventDefault();
            } else {
                // Si al menos un checkbox está seleccionado, oculta el mensaje de error
                operacionError.style.display = "none";
            }
        });
    });
</script>

<script> //validacion categoria
    document.addEventListener("DOMContentLoaded", function () {
        var form = document.getElementById("categoria");
        var operacionError = document.getElementById("operacionError2");

        form.addEventListener("submit", function (event) {
            var checkboxes = form.querySelectorAll(".operacion-checkbox");
            var checkboxSeleccionado = Array.from(checkboxes).some(function (checkbox) {
                return checkbox.checked;
            });

            if (!checkboxSeleccionado) {
                // Si ningún checkbox está seleccionado, muestra el mensaje de error
                operacionError.style.display = "block";
                event.preventDefault();
            } else {
                // Si al menos un checkbox está seleccionado, oculta el mensaje de error
                operacionError.style.display = "none";
            }
        });
    });
</script>

<script> //validacionmarca
    document.addEventListener("DOMContentLoaded", function () {
        var form = document.getElementById("marca");
        var operacionError = document.getElementById("operacionError3");

        form.addEventListener("submit", function (event) {
            var checkboxes = form.querySelectorAll(".operacion-checkbox");
            var checkboxSeleccionado = Array.from(checkboxes).some(function (checkbox) {
                return checkbox.checked;
            });

            if (!checkboxSeleccionado) {
                // Si ningún checkbox está seleccionado, muestra el mensaje de error
                operacionError.style.display = "block";
                event.preventDefault();
            } else {
                // Si al menos un checkbox está seleccionado, oculta el mensaje de error
                operacionError.style.display = "none";
            }
        });
    });
</script>




@endpush

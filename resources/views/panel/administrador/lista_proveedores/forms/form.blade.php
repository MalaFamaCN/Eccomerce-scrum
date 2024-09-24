<div class="card mb-5">
    <form action="{{ $proveedor->id ? route('proveedor.update', $proveedor) : route('proveedor.store') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @if ($proveedor->id)
            @method('PUT')
        @endif

        <div class="card-body">

            {{-- @if ($post->id) --}}
            {{-- <div class="mb-3 row">
                <img src="{{ $producto->imagen ?? 'https://via.placeholder.com/1024'}}" alt="{{ $producto->nombre }}" id="image_preview" class="img-fluid" style="object-fit: cover; object-position: center; height: 420px; width: 100%;">
            </div> --}}
            {{-- @endif --}}



            <div class="mb-3 row">
                <label for="nombre" class="col-sm-4 col-form-label"> * Nombre </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control @error('descripcion') is-invalid @enderror"
                        id="descripcion" name="descripcion"
                        value="{{ old('descripcion', optional($proveedor)->descripcion) }}">
                    @error('descripcion')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <label for="cuit" class="col-sm-4 col-form-label"> * CUIT </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control @error('cuit') is-invalid @enderror" id="cuit"
                        name="cuit" value="{{ old('cuit', optional($proveedor)->cuit) }}" minlength="13" maxlength="14">
                    @error('cuit')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <label for="razon_social" class="col-sm-4 col-form-label"> * Razón Social </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control @error('razon_social') is-invalid @enderror"
                        id="razon_social" name="razon_social"
                        value="{{ old('razon_social', optional($proveedor)->razon_social) }}">
                    @error('razon_social')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <label for="direccion" class="col-sm-4 col-form-label"> * Dirección </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control @error('direccion') is-invalid @enderror"
                        id="direccion" name="direccion"
                        value="{{ old('direccion', optional($proveedor)->direccion) }}">
                    @error('direccion')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <label for="telefono" class="col-sm-4 col-form-label"> * Telefono </label>
                <div class="col-sm-8">
                    <input type="number" class="form-control @error('telefono') is-invalid @enderror" id="telefono"
                        name="telefono" value="{{ old('telefono', optional($proveedor)->telefono) }}">
                    @error('telefono')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <label for="correo" class="col-sm-4 col-form-label"> * Correo </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control @error('correo') is-invalid @enderror"
                        id="correo" name="correo"
                        value="{{ old('correo', optional($proveedor)->correo) }}">
                    @error('correo')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <label for="estado" class="col-sm-4 col-form-label"> * Estado </label>
                <div class="col-sm-8">
                    <select class="form-control @error('activo') is-invalid @enderror" name="activo" id="activo" value="{{ old('activo', optional($proveedor)->activo) }}">
                        <option value="1" @if ($proveedor->activo) {{"selected"}} @endif>Activado</option>
                        <option value="0" @if (isset($proveedor->activo) and !$proveedor->activo) {{"selected"}} @endif>Desactivado</option>
                    </select>

                    {{-- <input type="text" class="form-control @error('activo') is-invalid @enderror" id="activo"
                        name="activo" value="{{ old('activo', optional($proveedor)->activo) }}"> --}}
                    @error('activo')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
            </div>

            {{-- <div class="mb-3 row">
                <label for="imagen" class="col-sm-4 col-form-label"> * Imagen </label>
                <div class="col-sm-8">
                    <input class="form-control @error('imagen') is-invalid @enderror" type="file" id="imagen" name="imagen" accept="image/*">
                    @error('imagen')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                    </div>
                </div>
            --}}
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success text-uppercase">
                {{ $proveedor->id ? 'Actualizar' : 'Guardar' }}
            </button>
        </div>
    </form>

</div>

@push('js')
@endpush

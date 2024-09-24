<div class="card mb-5">
    <form action="{{ $producto->id ? route('precio.update', $producto) : route('producto.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($producto->id)
            @method('PUT')
        @endif

        <div class="card-body">

            <div class="mb-3">
                @foreach ($imagenes as $imagen)
                    <img src="{{ $imagen }}" alt="{{ $producto->nombre }}" id="image_preview" class="img-fluid" style="object-fit: cover; object-position: center; height: 250px; width: 250px;">
                @endforeach
            </div>

            <div class="mb-3">
                <h5><strong>Codigo:</strong> {{ $producto->codigo_producto }}</h5>
            </div>

            <div class="mb-3">
                <h5><strong>Nombre:</strong> {{ $producto->nombre }}</h5>
            </div>

            <div class="mb-3">
                <h5><strong>Proveedor:</strong> {{ $proveedor->descripcion }}</h5>
            </div>
            <div class="mb-3">
                <h5><strong>Categoria:</strong> {{ $producto->categoria->descripcion }}</h5>
            </div>
            <div class="mb-3">
                <h5><strong>Marca:</strong> {{ $producto->marca->descripcion }}</h5>
            </div>

            <div class="mb-3 row">
                <label for="precio" class="col-sm-4 col-form-label">
                    <h5><strong>Precio:</strong></h5>
                </label>
                <div class="col-sm-8">
                    <input type="number" class="form-control @error('precio') is-invalid @enderror" id="precio" placeholder="precio del producto" name="precio" value="{{ old('precio', optional($producto)->precio) }}" maxlength="9">
                    @error('precio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success text-uppercase">
                {{ $producto->id ? 'Actualizar' : 'Guardar' }}
            </button>
        </div>
    </form>
</div>

@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        const image = document.getElementById('url_imagen');

        image.addEventListener('change', (e) => {
            const input = e.target;
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');

            if (document.getElementById('imagePreviewDefault') !== null) {
                console.log('eliminando preview');
                document.getElementById('imagePreviewDefault').remove();
            }

            imagePreviewContainer.innerHTML = '';

            if (input.files.length > 0) {
                for (let i = 0; i < Math.min(input.files.length, 3); i++) {
                    const file = input.files[i];
                    const objectURL = URL.createObjectURL(file);
                    const img = document.createElement('img');
                    img.src = objectURL;
                    img.classList.add('preview-image');
                    img.src = objectURL;
                    img.classList.add('preview-image');
                    img.style.objectFit = 'cover';
                    img.style.objectPosition = 'center';
                    img.style.height = '250px';
                    img.style.width = '250px';
                    imagePreviewContainer.appendChild(img);
                }
            }
        });
    });
</script>
@endpush

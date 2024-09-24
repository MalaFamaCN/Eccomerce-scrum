<div class="modal fade" id="proveedorModal{{ $proveedor->id }}" tabindex="-1" role="dialog"
    aria-labelledby="proveedorModalLabel{{ $proveedor->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="proveedorModalLabel{{ $proveedor->id }}"><strong> Datos del Proveedor:
                    "{{ $proveedor->descripcion }}" </strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Contenido del modal --}}
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-light pb-0">
                        <strong>Nombre:</strong> <p>{{ $proveedor->descripcion }}</p>
                    </li>
                    <li class="list-group-item pb-0">
                        <strong>CUIT:</strong> <p>{{$proveedor->cuit}}</p>
                    </li>
                    <li class="list-group-item bg-light pb-0">
                        <strong>Razon Social:</strong> <p>{{ $proveedor->razon_social }}</p>
                    </li>
                    <li class="list-group-item pb-0">
                        <strong>Dirección:</strong><p> {{ $proveedor->direccion }}</p>
                    </li>
                    <li class="list-group-item bg-light pb-0">
                        <strong>Telefono:</strong> <p>{{ $proveedor->telefono }}</p>
                    </li>
                    <li class="list-group-item pb-0">
                        <strong>Correo:</strong><p> {{ $proveedor->correo }}</p>
                    </li>
                    {{-- <li class="list-group-item bg-light pb-0">
                        <strong>Estado:</strong> <p>@if ($proveedor->activo){{"Activado"}} @else {{"Desactivado"}}@endif</p>
                    </li> --}}
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



                   
                    

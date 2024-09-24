<div class="modal fade" id="userModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="userModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title " id="userModalLabel{{ $user->id }}"><strong>Detalles del Usuario: "{{ $user->name }} {{ $user->apellido }}"</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Contenido del modal --}}
                <ul class="list-group list-group-flush">
                <li class="list-group-item bg-light pb-0">
                    <strong>Nombre:</strong><p> {{ $user->name }} {{ $user->apellido }} </p>
                </li>
                <li class="list-group-item pb-0">
                    <strong>E-mail:</strong><p> {{ $user->email }}</p>
                </li>
                <li class="list-group-item bg-light pb-0">
                    <strong>DNI:</strong><p> {{ $user->dni }}</p>
                </li>
                <li class="list-group-item pb-0">
                    <strong>Teléfono:</strong><p> {{ $user->telefono }}</p>
                </li>
                <li class="list-group-item bg-light pb-0">
                    <strong>Rol:</strong><p> @foreach($user->getRoleNames() as $role)
                        {{ ucfirst($role) }}
                    @endforeach</p>
                </li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

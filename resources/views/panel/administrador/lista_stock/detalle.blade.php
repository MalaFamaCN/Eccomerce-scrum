<div class="modal fade" id="registroModal{{ $registro->id }}" tabindex="-1" role="dialog" aria-labelledby="registroModalLabel{{ $registro->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registroModalLabel{{ $registro->id }}"> <strong>Detalles de la Modificación de {{ $registro->producto->nombre }}</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Contenido del modal --}}
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 text-muted">Núm. de Registro #{{ $registro->num_registro }}</div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-4"><strong>Tipo de Modif.</strong></div>
                                <div class="col-sm-2">
                                    {!!
                                        $registro->tipo_modif == 'alta'
                                            ? '<span class="badge badge-success p-1">' . $registro->tipo_modif . '</span>'
                                            : ($registro->tipo_modif == 'ingreso'
                                            ? '<span class="badge badge-primary p-1">' . $registro->tipo_modif . '</span>'
                                            : '<span class="badge badge-danger p-1">' . $registro->tipo_modif . '</span>')
                                    !!}
                                </div>
                                <div class="col-sm-4"><strong>Valor de la Modif.</strong></div>
                                <div class="col-sm-2">{{ $registro->cantidad_modif }}</div>
                                <div class="col-sm-4"><strong>Stock Anterior</strong></div>
                                <div class="col-sm-2">{{ $registro->cantidad_anterior }}</div>
                                <div class="col-sm-4"><strong>Stock Resultante</strong></div>
                                <div class="col-sm-2">{{ $registro->cantidad_nueva }}</div>
                            </div>
                        </li>
                        <li class="list-group-item bg-light">
                            <strong>Motivo:</strong><p> {{ $registro->motivo_modif }} </p>
                        </li>
                        <li class="list-group-item text-muted">
                            Relizado por {{ $registro->user->name .' '. $registro->user->apellido }} <br>
                            Usuario {{ $registro->user->email }} el {{ $registro->created_at}}.
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-footer text-muted d-flex justify-content-end">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@props([
    'id' => 'userModal',
    'title' => 'Detalles del Usuario' // Título por defecto.
])

<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Los IDs de los 'span' se mantienen fijos para que el script de AJAX los encuentre --}}
                <p><strong>ID:</strong> <span id="modalUserId"></span></p>
                <p><strong>Nombre:</strong> <span id="modalUserName"></span></p>
                <p><strong>Email:</strong> <span id="modalUserEmail"></span></p>
                <p><strong>Roles:</strong> <span id="modalUserRoles"></span></p>

                {{-- Si quisieras añadir más contenido dinámico, puedes usar $slot --}}
                {{-- {{ $slot }} --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
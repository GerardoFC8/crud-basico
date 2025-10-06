@extends('adminlte::page')

@section('title', 'Usuarios')

@section('plugins.Datatables', true)

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Listado de Usuarios</h1>
        {{-- @can('users.create') --}}
        <a href="{{ route('users.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Crear Nuevo</a>
        {{-- @endcan --}}
    </div>
@stop

@section('content')

    {{-- {{ $data }}
    <br>
    <br>
    @foreach ($data as $user)
        {{  $user  }} <br><br>
    @endforeach --}}

    <div class="card">
        <div class="card-body">
            <table id="usersTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Tipo</th>
                        <th>Roles</th>
                        <th width="150px">Acciones</th> {{-- Aumenté un poco el ancho --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge badge-secondary">{{ $user->userType->name ?? 'N/A' }}</span>
                            </td>
                            <td>
                                @forelse($user->getRoleNames() as $role)
                                    <span class="badge badge-primary mr-1">{{ $role }}</span>
                                @empty
                                    <span class="badge badge-light">Sin roles</span>
                                @endforelse
                            </td>
                            <td>
                                {{-- El data-target apunta a un ID único: "modalUsuario-1", "modalUsuario-2", etc. --}}
                                <button type="button" class="btn btn-sm btn-info" title="Ver"
                                        data-toggle="modal"
                                        data-target="#modalUsuario-{{ $user->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <x-componente-asd :id="$user->id" id-modal="modalUsuario-{{ $user->id }}">
                                    <p><strong>Nombre:</strong> {{ $component->usuario->name ?? 'N/A' }}</p>
                                    <p><strong>Email:</strong> {{ $component->usuario->email ?? 'N/A' }}</p>
                                </x-componente-asd>

                                <button type="button" class="btn btn-sm btn-warning view-user-btn" title="Ver"
                                        data-toggle="modal"
                                        data-target="#userModal"
                                        data-user-id="{{ $user->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro?');">
                                    @can('users.edit')
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-primary" title="Editar"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @csrf
                                    @method('DELETE')
                                    @can('users.destroy')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"><i class="fas fa-trash"></i></button>
                                    @endcan
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#usersModal">
        Ver Resumen de Usuarios 
    </button>

    <!-- Llamada al componente modal -->
    <x-bootstrap-modal id="usersModal" title="Resumen de Usuarios">
        {{-- <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <!-- Aquí puedes agregar campos de formulario si es necesario -->
            FORMULARIO
            <input type="text" name="name" placeholder="Nombre" required>
            <input type="email" name="email" placeholder="Email" required>
            <x-slot name="footer">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </x-slot>
        </form> --}}

        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <x-slot name="footer">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar cambios</button>
            </div>
        </x-slot>
    </x-bootstrap-modal>

    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#usuario">
        Ver Usuario 1
    </button>

    <x-componente-asd id="1" idModal="usuario">
        <p>Nombre: {{ $component->usuario->name ?? 'No hay usuario' }}</p>
        <p>Email: {{ $component->usuario->email ?? 'No hay usuario' }}</p>
    </x-componente-asd>


    {{-- CON AJAX Y UN SOLO MODAL PARA TODOS LOS USUARIOS --}}
    {{-- <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Detalles del Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>ID:</strong> <span id="modalUserId"></span></p>
                <p><strong>Nombre:</strong> <span id="modalUserName"></span></p>
                <p><strong>Email:</strong> <span id="modalUserEmail"></span></p>
                <p><strong>Roles:</strong> <span id="modalUserRoles"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div> --}}
    <x-user-info-modal id="userModal" />

@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                "language": { "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json" }
            });
        });
    </script>

    <script>
    $(document).ready(function() {
        // Escucha el evento 'click' en CUALQUIER botón que tenga la clase 'view-user-btn'
        $('.view-user-btn').on('click', function() {
            
            // 1. Obtiene el ID del usuario desde el atributo data-user-id del botón
            var userId = $(this).data('user-id');

            // Muestra un estado de carga mientras se obtienen los datos (opcional)
            $('#modalUserId').text('Cargando...');
            $('#modalUserName').text('Cargando...');
            $('#modalUserEmail').text('Cargando...');
            $('#modalUserRoles').text('Cargando...');

            // 2. Hace la petición AJAX a la ruta que creamos
            $.ajax({
                url: '/users/' + userId + '/json', // Construye la URL
                type: 'GET',
                success: function(response) {
                    // 3. Si la petición es exitosa, rellena el modal con los datos
                    $('#modalUserId').text(response.id);
                    $('#modalUserName').text(response.name);
                    $('#modalUserEmail').text(response.email);
                    
                    // Formatea los roles si existen
                    var roles = response.roles.map(function(role) {
                        return '<span class="badge badge-primary mr-1">' + role.name + '</span>';
                    }).join('');

                    $('#modalUserRoles').html(roles || '<span class="badge badge-light">Sin roles</span>');
                },
                error: function() {
                    // Maneja el error si no se pueden cargar los datos
                    alert('No se pudieron cargar los datos del usuario.');
                }
            });
        });
    });
    </script>
@stop

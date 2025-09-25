@extends('adminlte::page')

@section('title', 'Usuarios')

@section('plugins.Datatables', true)

@section('content_header')
    <h1>Listado de Usuarios</h1>
@stop

@section('content')
    <div class="card">
        
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <strong>¡Éxito!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card-body">
            <table id="usersTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Permisos Directos</th>
                        <th width="100px">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @forelse($user->getRoleNames() as $role)
                                    <span class="badge badge-primary mr-1">{{ $role }}</span>
                                @empty
                                    <span class="badge badge-secondary">Sin roles</span>
                                @endforelse
                            </td>
                            <td>
                                @forelse($user->getDirectPermissions() as $permission)
                                    <span class="badge badge-info mr-1">{{ $permission->name }}</span>
                                @empty
                                    <span class="badge badge-secondary">Ninguno</span>
                                @endforelse
                            </td>
                            <td>
                                @can('users.edit')
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-primary" title="Editar Roles y Permisos"><i class="fas fa-edit"></i></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                }
            });
        });
    </script>
@stop
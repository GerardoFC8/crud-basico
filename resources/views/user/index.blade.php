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
                                <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');">
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
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                "language": { "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json" }
            });
        });
    </script>
@stop

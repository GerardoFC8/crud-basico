@extends('adminlte::page')

@section('title', 'Permisos')

@section('plugins.Datatables', true)

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Listado de Permisos</h1>
        <a href="{{ route('permissions.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Crear Nuevo
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="permissionsTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th width="150px">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $permission->id }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>
                                <a href="{{ route('permissions.show', $permission) }}" class="btn btn-sm btn-info" title="Ver"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-sm btn-primary" title="Editar"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('permissions.destroy', $permission) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"><i class="fas fa-trash"></i></button>
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
            $('#permissionsTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                }
            });
        });
    </script>
@stop

@extends('adminlte::page')

@section('title', 'Tipos de Usuario')

@section('plugins.Datatables', true)

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Tipos de Usuario</h1>
        <a href="{{ route('user-types.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Crear Nuevo
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="userTypesTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th width="150px">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userTypes as $type)
                        <tr>
                            <td>{{ $type->id }}</td>
                            <td>{{ $type->name }}</td>
                            <td>{{ $type->description }}</td>
                            <td>
                                <form action="{{ route('user-types.destroy', $type) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');">
                                    <a href="{{ route('user-types.edit', $type) }}" class="btn btn-sm btn-primary" title="Editar"><i class="fas fa-edit"></i></a>
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
            $('#userTypesTable').DataTable({
                "language": { "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json" }
            });
        });
    </script>
@stop

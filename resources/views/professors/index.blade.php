@extends('adminlte::page')

@section('title', 'Gestión de Profesores')

@section('content_header')
    <h1>Gestión de Profesores</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        @can('professors.create')
        <a href="{{ route('professors.create') }}" class="btn btn-primary">
            Crear Nuevo Profesor
        </a>
        @endcan
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($professors as $professor)
                <tr>
                    <td>{{ $professor->name }}</td>
                    <td>{{ $professor->email }}</td>
                    <td>
                        @foreach($professor->getRoleNames() as $role)
                            <span class="badge badge-success">{{ $role }}</span>
                        @endforeach
                    </td>
                    <td width="10px">
                        @can('professors.edit')
                        <a href="{{ route('professors.edit', $professor) }}" class="btn btn-sm btn-primary">Editar</a>
                        @endcan
                    </td>
                    <td width="10px">
                        @can('professors.destroy')
                        <form action="{{ route('professors.destroy', $professor) }}" method="POST" onsubmit="return confirm('¿Estás seguro de querer eliminar este profesor?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop
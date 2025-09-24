@extends('adminlte::page')

@section('title', 'Detalle de Rol')

@section('content_header')
    <h1>Detalle del Rol</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información del Rol</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <strong>ID:</strong>
                <p>{{ $role->id }}</p>
            </div>
            <div class="form-group">
                <strong>Nombre:</strong>
                <p>{{ $role->name }}</p>
            </div>
             <div class="form-group">
                <strong>Guard:</strong>
                <p>{{ $role->guard_name }}</p>
            </div>
             <div class="form-group">
                <strong>Permisos Asignados:</strong>
                <div>
                    @forelse($role->permissions as $permission)
                        <span class="badge badge-info">{{ $permission->name }}</span>
                    @empty
                        <span class="badge badge-secondary">Ninguno</span>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Volver al listado</a>
            <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary">Editar</a>
        </div>
    </div>
@stop

@extends('adminlte::page')

@section('title', 'Detalle de Permiso')

@section('content_header')
    <h1>Detalle del Permiso</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información del Permiso</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <strong>ID:</strong>
                <p>{{ $permission->id }}</p>
            </div>
            <div class="form-group">
                <strong>Nombre:</strong>
                <p>{{ $permission->name }}</p>
            </div>
             <div class="form-group">
                <strong>Guard:</strong>
                <p>{{ $permission->guard_name }}</p>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Volver al listado</a>
            <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-primary">Editar</a>
        </div>
    </div>
@stop

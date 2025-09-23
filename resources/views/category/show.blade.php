@extends('adminlte::page')

@section('title', 'Detalle de Categoría')

@section('content_header')
    <h1>Detalle de la Categoría</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información de la Categoría</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <strong>ID:</strong>
                <p>{{ $category->id }}</p>
            </div>
            <div class="form-group">
                <strong>Nombre:</strong>
                <p>{{ $category->name }}</p>
            </div>
            <div class="form-group">
                <strong>Descripción:</strong>
                <p>{{ $category->description ?? 'N/A' }}</p>
            </div>
             <div class="form-group">
                <strong>Creado en:</strong>
                <p>{{ $category->created_at->format('d/m/Y H:i:s') }}</p>
            </div>
             <div class="form-group">
                <strong>Última actualización:</strong>
                <p>{{ $category->updated_at->format('d/m/Y H:i:s') }}</p>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Volver al listado</a>
            <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary">Editar</a>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
@stop

@section('js')
    {{-- Add here extra scripts --}}
@stop

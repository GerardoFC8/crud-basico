@extends('adminlte::page')

@section('title', 'Crear Profesor')

@section('content_header')
    <h1>Crear Nuevo Profesor</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('professors.store') }}" method="POST">
            @csrf
            @include('professors._form')
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('professors.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@stop


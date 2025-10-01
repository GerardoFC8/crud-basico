@extends('adminlte::page')

@section('title', 'Crear Usuario')

@section('content_header')
    <h1>Crear Nuevo Usuario</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @include('user._form')
                <button type="submit" class="btn btn-primary mt-3">Guardar Usuario</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
            </form>
        </div>
    </div>
@stop

@extends('adminlte::page')

@section('title', 'Crear Tipo de Usuario')

@section('content_header')
    <h1>Crear Tipo de Usuario</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('user-types.store') }}" method="POST">
                @include('user-types._form')
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('user-types.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop

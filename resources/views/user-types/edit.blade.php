@extends('adminlte::page')

@section('title', 'Editar Tipo de Usuario')

@section('content_header')
    <h1>Editar Tipo de Usuario</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('user-types.update', $userType) }}" method="POST">
                @method('PUT')
                @include('user-types._form')
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('user-types.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop

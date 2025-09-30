@extends('adminlte::page')

@section('title', 'Editar Profesor')

@section('content_header')
    <h1>Editar Profesor</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('professors.update', $professor) }}" method="POST">
            @csrf
            @method('PUT')
            @include('professors._form', ['professor' => $professor])
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('professors.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@stop


@extends('adminlte::page')

@section('title', 'Editar Estudiante')

@section('content_header')
    <h1>Editar Estudiante</h1>
@stop

@section('content')
    <div class="container-fluid pt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <form method="post" action="{{ route('students.update', $student->id) }}">
                        @method('PUT')
                        <div class="card-header">
                            <h3 class="card-title">Editando Estudiante: {{ $student->nombres }}</h3>
                        </div>
                        <div class="card-body">
                            @include('students._form', ['student' => $student])
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop

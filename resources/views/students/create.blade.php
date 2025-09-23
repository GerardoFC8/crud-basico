@extends('adminlte::page')

@section('title', 'Crear Estudiante')

@section('content_header')
    <h1>Crear Estudiante</h1>
@stop

@section('content')
    <div class="container-fluid pt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <form method="post" action="{{ route('students.store') }}">
                        <div class="card-header">
                            <h3 class="card-title">Formulario de Nuevo Estudiante</h3>
                        </div>
                        <div class="card-body">
                            @include('students._form')
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

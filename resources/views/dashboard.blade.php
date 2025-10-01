@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <p>¡Bienvenido a tu panel de control, {{ Auth::user()->name }}!</p>
                    @if(session('active_role'))
                        <p>Has ingresado con el rol: <span class="badge badge-success">{{ session('active_role') }}</span></p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Contenido visible solo para el Admin y PostsManager --}}
    @can('posts.index')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Gestión de Contenido</h3>
                </div>
                <div class="card-body">
                    <p>Administra las publicaciones y categorías del blog.</p>
                    <a href="{{ route('posts.index') }}" class="btn btn-primary">Ir a Publicaciones</a>
                </div>
            </div>
        </div>
    @endcan

    {{-- Contenido visible solo para el Admin --}}
    @role('Admin')
        <div class="col-md-4">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Administración del Sistema</h3>
                </div>
                <div class="card-body">
                    <p>Gestiona usuarios, roles y permisos de la aplicación.</p>
                    <a href="{{ route('users.index') }}" class="btn btn-danger">Administrar Usuarios</a>
                </div>
            </div>
        </div>
    @endrole

    {{-- Cerrar el .row si se abrió --}}
    @can('posts.index')
    </div>
    @endcan


    {{-- Contenido específico para el rol "Profesor" --}}
    @role('Profesor')
    <div class="row">
        <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Panel del Profesor</h3>
                </div>
                <div class="card-body">
                    <p>Aquí puedes gestionar tus cursos, ver tus alumnos y calificar tareas.</p>
                    {{-- Aquí irían enlaces a las rutas de profesores --}}
                </div>
            </div>
        </div>
    </div>
    @endrole

    {{-- Contenido específico para el rol "Alumno" --}}
    @role('Alumno')
    <div class="row">
        <div class="col-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Portal del Alumno</h3>
                </div>
                <div class="card-body">
                    <p>Bienvenido. Aquí puedes ver tus cursos inscritos, tus calificaciones y el material de estudio.</p>
                     {{-- Aquí irían enlaces a las rutas de alumnos --}}
                </div>
            </div>
        </div>
    </div>
    @endrole
@stop

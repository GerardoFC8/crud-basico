@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard con Modales</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ejemplos de Modales</h3>
        </div>
        <div class="card-body">
            
            <!-- Botón para abrir el primer modal (Ajustado para Bootstrap 4) -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalSimple">
                Abrir Modal Simple
            </button>

            <!-- Botón para abrir el segundo modal (Ajustado para Bootstrap 4) -->
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalFormulario">
                Abrir Modal con Formulario
            </button>
        </div>
    </div>

    <x-modal id="modalSimple" title="Confirmación">
        <p>¿Estás seguro de que quieres realizar esta acción?</p>
        <p>Esta operación no se puede deshacer.</p>

        <x-slot:footer>
            <button type="button" class="btn btn-danger">Sí, estoy seguro</button>
        </x-slot:footer>
    </x-modal>


    <x-modal id="modalFormulario" title="Crear Nuevo Usuario">
        {{-- Podemos incluir un formulario completo dentro del modal --}}
        <form>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="name" placeholder="Ej: Juan Pérez">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" placeholder="juan.perez@example.com">
            </div>
        </form>

        <x-slot:footer>
            <button type="button" class="btn btn-primary">Guardar Usuario</button>
        </x-slot:footer>
    </x-modal>

@stop

@section('css')
    {{-- AdminLTE ya incluye Bootstrap, así que no es necesario añadirlo. --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop


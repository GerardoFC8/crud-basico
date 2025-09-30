@extends('adminlte::page')

@section('title', 'Lista de estudiantes')

@section('plugins.Datatables', true)

@section('content_header')
    {{-- <h1>Lista de estudiantes</h1> --}}
@stop

@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Lista de Estudiantes</h3>
                <a href="{{ route('students.create') }}" class="btn btn-primary">
                    Crear Estudiante
                </a>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="table-responsive">
                    {{-- Se le asigna un ID a la tabla para Datatables --}}
                    <table class="table table-striped table-hover" id="students-table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Nombres</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Cédula</th>
                                <th scope="col">Estado</th>
                                <th scope="col" class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr>
                                    <td>{{ $student->nombres }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->cedula }}</td>
                                    <td>
                                        @php
                                            $statusClass = '';
                                            switch ($student->status) {
                                                case 'activo':
                                                    $statusClass = 'badge bg-success';
                                                    break;
                                                case 'inactivo':
                                                    $statusClass = 'badge bg-danger';
                                                    break;
                                                default:
                                                    $statusClass = 'badge bg-info';
                                                    break;
                                            }
                                        @endphp
                                        <span class="{{ $statusClass }}">{{ ucfirst($student->status) }}</span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline-block ms-1" onsubmit="return confirm('¿Estás seguro de que quieres eliminar a este estudiante?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No hay estudiantes registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Aquí puedes añadir CSS personalizado si es necesario --}}
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#students-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "paging": true,
            "searching": true,
            "info": true,
            "lengthChange": false,
            "pageLength": 10,
            "columnDefs": [
                { "orderable": false, "targets": 4 }
            ]
        });
    });
</script>
@stop
@extends('adminlte::page')

@section('title', 'Lista de estudiantes')

@section('content_header')
    <h1>Lista de estudiantes</h1>
@stop

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Lista de Estudiantes (Controlador)</h1>
            <a href="{{ route('students.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md shadow-sm">
                Crear Estudiante
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Input de Búsqueda -->
            <div class="p-4">
                <input type="text" id="search-input" class="w-full rounded-md border-gray-300 shadow-sm" placeholder="Buscar por nombre, correo o cédula...">
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="students-table">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombres</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cédula</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Acciones</span>
                            </th>
                        </tr>
                    </thead>
                    <!-- Contenedor permanente para las filas de la tabla -->
                    <tbody id="students-table-body" class="bg-white divide-y divide-gray-200">
                        @include('students._table', ['students' => $students])
                    </tbody>
                </table>
            </div>
            <!-- Contenedor permanente para la paginación -->
            <div id="students-pagination" class="p-4">
                {{ $students->links() }}
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
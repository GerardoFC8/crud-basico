@extends('adminlte::page')

@section('title', 'Crear Estudiante')

@section('content_header')
    <h1>Crear Estudiante</h1>
@stop

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form method="post" action="{{ route('students.store') }}">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <h2 class="text-2xl font-semibold mb-4">Crear Nuevo Estudiante</h2>
                                @include('students._form')
                            </div>
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
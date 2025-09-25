@extends('adminlte::page')

@section('title', 'Posts')

@section('plugins.Datatables', true)

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Listado de Posts</h1>
        @can('posts.create')
        <a href="{{ route('posts.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Crear Nuevo
        </a>
        @endcan
    </div>
@stop

@section('content')
    <div class="card">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <strong>¡Éxito!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        
        <div class="card-body">
            <table id="postsTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th>Destacado</th>
                        <th width="150px">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>
                                @if($post->image_path)
                                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->category->name ?? 'N/A' }}</td>
                            <td>
                                @if($post->status == 'published')
                                    <span class="badge badge-success">Publicado</span>
                                @elseif($post->status == 'draft')
                                    <span class="badge badge-secondary">Borrador</span>
                                @else
                                    <span class="badge badge-warning">Archivado</span>
                                @endif
                            </td>
                            <td>
                                @if($post->is_featured)
                                    <span class="badge badge-primary">Sí</span>
                                @else
                                    <span class="badge badge-light">No</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este post?');">
                                    <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-info" title="Ver"><i class="fas fa-eye"></i></a>
                                    @can('posts.edit')
                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-primary" title="Editar"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @csrf
                                    @method('DELETE')
                                    @can('posts.destroy')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"><i class="fas fa-trash"></i></button>
                                    @endcan
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#postsTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
                "columnDefs": [
                    { "orderable": false, "targets": [1, 6] } // Deshabilitar orden en columnas de imagen y acciones
                ]
            });
        });
    </script>
@stop

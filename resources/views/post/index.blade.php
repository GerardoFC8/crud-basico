@extends('adminlte::page')

@section('title', 'Posts')

@section('plugins.Datatables', true)

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Listado de Posts</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Crear Nuevo
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="postsTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
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
                                <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                    <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-info" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-primary" title="Editar"><i class="fas fa-edit"></i></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"><i class="fas fa-trash"></i></button>
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
                }
            });
        });
    </script>
@stop

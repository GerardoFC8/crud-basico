@extends('adminlte::page')

@section('title', 'Posts')

@section('plugins.Datatables', true)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Listado de Posts</h1>
        <div>
            <!-- BOTÓN NUEVO PARA PDF -->
            <a href="{{ route('posts.pdf') }}" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> Generar Reporte PDF
            </a>

            <a href="{{ route('posts.excel') }}" class="btn btn-success" target="_blank">
                <i class="fas fa-file-excel"></i> Exportar a Excel
            </a>
            
            @can('posts.create')
            <a href="{{ route('posts.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Crear Nuevo
            </a>
            @endcan
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <strong>¡Éxito!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        @endif

        {{-- {{ public_path('storage/posts/1759854165-rm378-07jpg.jpg') }}
        <img src="{{ public_path('storage/posts/1759854165-rm378-07jpg.jpg') }}" class="main-image">
        <img src="{{ asset('storage/posts/1759854165-rm378-07jpg.jpg') }}" class="main-image">
        <br>
        {{ storage_path() }}
        <img src="{{ storage_path('app/private/posts/1759851702-gopng.png') }}" class="main-image"> --}}
        
        <div class="card-body">
            <table id="postsTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th>Tags</th>
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
                                @if($post->tags)
                                    @foreach($post->tags as $tag)
                                        <span class="badge badge-secondary">{{ $tag }}</span>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @if($post->status == 'published')<span class="badge badge-success">Publicado</span>
                                @elseif($post->status == 'draft')<span class="badge badge-secondary">Borrador</span>
                                @else<span class="badge badge-warning">Archivado</span>
                                @endif
                            </td>
                            <td>
                                @if($post->is_featured)<span class="badge badge-primary">Sí</span>
                                @else<span class="badge badge-light">No</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este post?');">
                                    <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-info" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('posts.single.pdf', $post) }}" class="btn btn-sm btn-secondary" title="Descargar PDF" target="_blank"><i class="fas fa-file-pdf"></i></a>
                                    <a href="{{ route('posts.single.excel', $post) }}" class="btn btn-sm btn-success" title="Exportar a Excel" target="_blank">
                                        <i class="fas fa-file-excel"></i>
                                    </a>
                                    @can('posts.edit')<a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-primary" title="Editar"><i class="fas fa-edit"></i></a>@endcan
                                    @csrf
                                    @method('DELETE')
                                    @can('posts.destroy')<button type="submit" class="btn btn-sm btn-danger" title="Eliminar"><i class="fas fa-trash"></i></button>@endcan
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
                    { "orderable": false, "targets": [1, 7] } // Deshabilitar orden en columnas de imagen y acciones
                ]
            });
        });
    </script>
@stop
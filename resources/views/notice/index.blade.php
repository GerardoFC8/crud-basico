@extends('adminlte::page')

@section('title', 'Noticias')

@section('plugins.Datatables', true)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Listado de Noticias</h1>
        <a href="{{ route('notices.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Crear Nueva
        </a>
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

        <div class="card-body">
            <table id="newsTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th>Tags</th>
                        <th>Estado</th>
                        <th width="120px">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notices as $notice)
                        <tr>
                            <td>{{ $notice->id }}</td>
                            <td>
                                @if($notice->image)
                                    <img src="{{ asset('storage/' . $notice->image) }}" alt="{{ $notice->title }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>{{ $notice->title }}</td>
                            <td>{{ $notice->category->name ?? 'N/A' }}</td>
                            <td>
                                @if($notice->tags)
                                    @foreach(explode(',', $notice->tags) as $tag)
                                        <span class="badge badge-secondary">{{ trim($tag) }}</span>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @if($notice->status == 'published')<span class="badge badge-success">Publicado</span>
                                @elseif($notice->status == 'draft')<span class="badge badge-secondary">Borrador</span>
                                @else<span class="badge badge-warning">Archivado</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('notices.destroy', $notice) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta noticia?');">
                                    <a href="{{ route('notices.show', $notice) }}" class="btn btn-sm btn-info" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('notices.edit', $notice) }}" class="btn btn-sm btn-primary" title="Editar"><i class="fas fa-edit"></i></a>
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
            $('#newsTable').DataTable({
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

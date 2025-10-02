@extends('adminlte::page')

@section('title', 'Detalle de Post')

@section('content_header')
    <h1>Detalle del Post</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $post->title }}</h3>
        </div>
        <div class="card-body">
             @if($post->image_path)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $post->image_path) }}" class="img-fluid rounded" alt="{{ $post->title }}" style="max-height: 400px;">
                </div>
            @endif
            <div class="row">
                <div class="col-md-8">
                    <strong>Contenido:</strong>
                    <div class="mt-2 p-3 bg-light rounded border">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    {{-- Mostrar Galería de Imágenes --}}
                    @if($post->gallery_images)
                        <hr>
                        <strong>Galería de Imágenes:</strong>
                        <div class="d-flex flex-wrap mt-2">
                            @foreach($post->gallery_images as $imagePath)
                                <a href="{{ asset('storage/' . $imagePath) }}" data-toggle="lightbox" data-gallery="gallery">
                                     <img src="{{ asset('storage/' . $imagePath) }}" class="img-thumbnail mr-2 mb-2" style="width: 150px; height: 150px; object-fit: cover;">
                                </a>
                            @endforeach
                        </div>
                    @endif

                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header"><strong>Detalles</strong></div>
                        <div class="card-body">
                            <p><strong>ID:</strong> {{ $post->id }}</p>
                            <p><strong>Categoría:</strong> <span class="badge badge-info">{{ $post->category->name ?? 'N/A' }}</span></p>
                            <p><strong>Tags:</strong> 
                                @if($post->tags)
                                    @foreach($post->tags as $tag)
                                        <span class="badge badge-secondary">{{ $tag }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </p>
                            <p><strong>Estado:</strong> 
                                @if($post->status == 'published')<span class="badge badge-success">Publicado</span>
                                @elseif($post->status == 'draft')<span class="badge badge-secondary">Borrador</span>
                                @else<span class="badge badge-warning">Archivado</span>
                                @endif
                            </p>
                            <p><strong>Destacado:</strong> 
                                @if($post->is_featured)<span class="badge badge-primary">Sí</span>
                                @else<span class="badge badge-light">No</span>
                                @endif
                            </p>
                            <p><strong>Vistas:</strong> {{ $post->views_count }}</p>
                            <hr>
                            <p><strong>Publicado en:</strong> {{ $post->published_at ? $post->published_at->format('d/m/Y H:i') : 'No publicado' }}</p>
                            <p><strong>Creado en:</strong> {{ $post->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    
                    {{-- Mostrar Información del Autor --}}
                    @if($post->author_info && $post->author_info->name)
                        <div class="card mt-3">
                             <div class="card-header"><strong>Info del Autor</strong></div>
                             <div class="card-body">
                                 <strong>Nombre:</strong> {{ $post->author_info->name }}<br>
                                 <strong>Bio:</strong> {{ $post->author_info->bio ?? 'N/A' }}
                             </div>
                        </div>
                    @endif

                    {{-- Mostrar Metadatos --}}
                    @if($post->meta_data && $post->meta_data->isNotEmpty())
                        <div class="card mt-3">
                            <div class="card-header"><strong>Metadatos</strong></div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    @foreach($post->meta_data as $meta)
                                        <tr>
                                            <th>{{ $meta['key'] }}:</th>
                                            <td>{{ $meta['value'] }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">Volver al listado</a>
            @can('posts.edit')
            <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary">Editar</a>
            @endcan
        </div>
    </div>
@stop

@section('plugins.EkkoLightbox', true)

@section('js')
<script>
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
</script>
@stop

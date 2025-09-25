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
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p><strong>ID:</strong> {{ $post->id }}</p>
                            <p><strong>Categoría:</strong> <span class="badge badge-info">{{ $post->category->name ?? 'N/A' }}</span></p>
                            <p><strong>Estado:</strong> 
                                @if($post->status == 'published')
                                    <span class="badge badge-success">Publicado</span>
                                @elseif($post->status == 'draft')
                                    <span class="badge badge-secondary">Borrador</span>
                                @else
                                    <span class="badge badge-warning">Archivado</span>
                                @endif
                            </p>
                            <p><strong>Destacado:</strong> 
                                @if($post->is_featured)
                                    <span class="badge badge-primary">Sí</span>
                                @else
                                    <span class="badge badge-light">No</span>
                                @endif
                            </p>
                            <p><strong>Vistas:</strong> {{ $post->views_count }}</p>
                            <hr>
                            <p><strong>Publicado en:</strong> {{ $post->published_at ? $post->published_at->format('d/m/Y H:i') : 'No publicado' }}</p>
                            <p><strong>Creado en:</strong> {{ $post->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
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
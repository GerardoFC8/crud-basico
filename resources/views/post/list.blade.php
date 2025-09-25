@extends('adminlte::page')

@section('title', 'Ver Publicaciones')

@section('content_header')
    {{-- Contenido del encabezado si es necesario --}}
@stop

@section('content')
    <div class="container blog-container py-4">
        <header class="text-center mb-5">
            <h1 class="display-4">Nuestro Blog</h1>
            <p class="lead text-muted">Las últimas noticias y artículos de nuestro equipo.</p>
        </header>

        <div class="row">
            @forelse ($posts as $post)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm post-card">
                        @if($post->image_path)
                            <a href="{{ route('posts.public.show', $post) }}">
                                <img src="{{ asset('storage/' . $post->image_path) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                            </a>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div class="post-meta mb-2">
                                <small class="text-muted">{{ $post->published_at ? $post->published_at->format('d \d\e F, Y') : '' }}</small> &middot;
                                <span class="badge badge-info">{{ $post->category->name ?? 'Sin categoría' }}</span>
                            </div>
                            <h5 class="card-title">
                                <a href="{{ route('posts.public.show', $post) }}" class="text-dark">{{ $post->title }}</a>
                            </h5>
                            <p class="card-text text-muted">{{ Str::limit($post->content, 100) }}</p>
                            <a href="{{ route('posts.public.show', $post) }}" class="btn btn-primary mt-auto align-self-start">Leer más →</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="lead">No hay publicaciones disponibles en este momento. ¡Vuelve pronto!</p>
                </div>
            @endforelse
        </div>
    </div>
@stop

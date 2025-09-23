@extends('adminlte::page')

@section('title', 'Ver Publicaciones')

@section('plugins.Datatables', true)

@section('content_header')
    {{-- <h1>Dashboard</h1> --}}
@stop

@section('content')
    <div class="container blog-container">
        <header class="text-center mb-5">
            <h1>Nuestro Blog</h1>
            <p class="lead">Las últimas noticias y artículos de nuestro equipo.</p>
        </header>

        @forelse ($posts as $post)
            <div class="card post-card">
                <div class="card-body">
                    <div class="post-meta">
                        <span>{{ $post->published_at ? $post->published_at->format('d \d\e F, Y') : '' }}</span> &middot;
                        <span class="badge badge-info">{{ $post->category->name ?? 'Sin categoría' }}</span>
                    </div>
                    <h2 class="card-title">
                        <a href="{{ route('posts.public.show', $post) }}">{{ $post->title }}</a>
                    </h2>
                    <p class="card-text">{{ Str::limit($post->content, 200) }}</p>
                    <a href="{{ route('posts.public.show', $post) }}" class="btn btn-primary">Leer más →</a>
                </div>
            </div>
        @empty
            <div class="text-center">
                <p>No hay publicaciones disponibles en este momento. ¡Vuelve pronto!</p>
            </div>
        @endforelse
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
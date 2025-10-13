@extends('adminlte::page')

@section('title', 'Detalle de Noticia')

@section('content_header')
    <h1>Detalle de la Noticia</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $notice->title }}</h3>
        </div>
        <div class="card-body">
             @if($notice->image)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $notice->image) }}" class="img-fluid rounded" alt="{{ $notice->title }}" style="max-height: 400px;">
                </div>
            @endif
            <div class="row">
                <div class="col-md-8">
                    <strong>Resumen:</strong>
                    <p class="text-muted">{{ $notice->summary }}</p>
                    <hr>
                    <strong>Contenido:</strong>
                    <div class="mt-2 p-3 bg-light rounded border">
                        {!! nl2br(e($notice->content)) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header"><strong>Detalles</strong></div>
                        <div class="card-body">
                            <p><strong>ID:</strong> {{ $notice->id }}</p>
                            <p><strong>Categoría:</strong> <span class="badge badge-info">{{ $notice->category->name ?? 'N/A' }}</span></p>
                            <p><strong>Tags:</strong> 
                                @if($notice->tags)
                                    @foreach(explode(',', $notice->tags) as $tag)
                                        <span class="badge badge-secondary">{{ trim($tag) }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </p>
                            <p><strong>Estado:</strong> 
                                @if($notice->status == 'published')<span class="badge badge-success">Publicado</span>
                                @elseif($notice->status == 'draft')<span class="badge badge-secondary">Borrador</span>
                                @else<span class="badge badge-warning">Archivado</span>
                                @endif
                            </p>
                            <p><strong>Fuente:</strong> 
                                @if($notice->source)
                                    <a href="{{ $notice->source }}" target="_blank">Ver fuente original</a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </p>
                            <hr>
                            <p><strong>Autor:</strong> {{ $notice->user->name ?? 'N/A' }}</p>
                            <p><strong>Publicado en:</strong> {{ $notice->published_at ? $notice->published_at->format('d/m/Y H:i') : 'No publicado' }}</p>
                            <p><strong>Creado en:</strong> {{ $notice->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('notice.index') }}" class="btn btn-secondary">Volver al listado</a>
            <a href="{{ route('notice.edit', $notice) }}" class="btn btn-primary">Editar</a>
        </div>
    </div>
@stop

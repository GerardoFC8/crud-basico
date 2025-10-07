<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Detalle de Post: {{ $post->title }}</title>
    <link rel="stylesheet" href="{{ public_path('css/bootstrap.css') }}" type="text/css">
    <style>
        body { font-family: 'Helvetica', }
        .content { white-space: pre-wrap; /* Respeta saltos de línea y espacios */ }
        .main-image { max-width: 50%; height: auto; border-radius: 8px; margin-bottom: 20px; }
        .gallery-image { width: 300px; height: 300px; object-fit: cover; border: 1px solid #ddd; border-radius: 5px; margin: 5px; }
        .page-break { page-break-after: always; }
        .page-break-before { page-break-before: always; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Título y Metadatos -->
        <div class="text-center mb-4">
            <h1>{{ $post->title }}</h1>
            <p class="text-muted">
                <strong>Autor:</strong> {{ $post->user->name ?? 'N/A' }} |
                <strong>Categoría:</strong> {{ $post->category->name ?? 'N/A' }} |
                <strong>Publicado:</strong> {{ $post->published_at ? $post->published_at->format('d/m/Y') : 'No publicado' }}
            </p>
        </div>

        <!-- Imagen Principal -->
        @if($post->image_path && file_exists(storage_path('app/public/' . $post->image_path)))
            <div class="text-center">
                <img src="{{ storage_path('app/public/' . $post->image_path) }}" class="main-image">
            </div>
        @endif

        <hr>

        <!-- Contenido Principal -->
        <div class="card my-4">
            <div class="card-header"><strong>Contenido del Post</strong></div>
            <div class="card-body content">
                {{ $post->content }}
            </div>
        </div>

        <!-- Detalles Adicionales -->
        <div class="row">
            <!-- Tags y Estado -->
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <strong>Estado:</strong>
                        @if($post->status == 'published')<span class="badge badge-success">Publicado</span>
                        @elseif($post->status == 'draft')<span class="badge badge-secondary">Borrador</span>
                        @else<span class="badge badge-warning">Archivado</span>
                        @endif
                        <hr>
                        <strong>Tags:</strong>
                        @if($post->tags && count($post->tags) > 0)
                            @foreach($post->tags as $tag)
                                <span class="badge badge-info">{{ $tag }}</span>
                            @endforeach
                        @else
                           <p>No hay tags.</p>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Metadatos -->
            @if($post->meta_data && $post->meta_data->isNotEmpty())
            <div class="col-6">
                 <div class="card">
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
            </div>
            @endif
        </div>

        <!-- Galería de Imágenes -->
        @if($post->gallery_images && count($post->gallery_images) > 0)
            <div class="card mt-4">
                <div class="card-header"><strong>Galería de Imágenes</strong></div>
                <div class="card-body">
                    @foreach($post->gallery_images as $imagePath)
                        @if(file_exists(storage_path('app/public/' . $imagePath)))
                            <img src="{{ storage_path('app/public/' . $imagePath) }}" class="gallery-image">
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    <div class="page-break-before">
        PAGINA 2
        asdasdasd
    </div>

    <div class="page-break-before">
        PAGINA 3
    </div>
</body>
</html>

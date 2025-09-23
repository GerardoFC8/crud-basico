<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>
    {{-- Usando Bootstrap para un estilo limpio y rápido --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .post-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        .post-title { 
            font-size: 2.5rem; 
            font-weight: bold;
            margin-bottom: 10px;
        }
        .post-meta {
            color: #6c757d;
            margin-bottom: 25px;
        }
        .post-content {
            font-size: 1.1rem;
            line-height: 1.7;
            white-space: pre-wrap; /* Respeta los saltos de línea y espacios */
        }
        .back-link {
            margin-top: 30px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="post-container">
            {{-- Título del Post --}}
            <h1 class="post-title">{{ $post->title }}</h1>
            
            {{-- Metadatos: Fecha y Categoría --}}
            <div class="post-meta">
                <span>Publicado el {{ $post->published_at ? $post->published_at->format('d \d\e F \d\e Y') : $post->created_at->format('d \d\e F \d\e Y') }}</span>
                |
                <span class="badge badge-info">{{ $post->category->name ?? 'Sin categoría' }}</span>
            </div>
            
            <hr>
            
            {{-- Contenido principal del Post --}}
            <div class="post-content">
                {{ $post->content }}
            </div>

            <a href="#" onclick="window.history.back(); return false;" class="btn btn-light back-link">← Volver atrás</a>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    
    <link rel="stylesheet" href="{{ public_path('css/bootstrap.css') }}" type="text/css">
</head>
<body>
    <div class="container-fluid">
        <div class="text-center my-4">
            <h1 class="text-info">{{ $title }}</h1>
            <p>Generado el: {{ $date }}</p>
        </div>

        <table class="table table-striped table-bordered table-sm">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Tags</th>
                    <th>Autor</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Fecha de Creación</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>
                            @if($post->tags)
                                @foreach($post->tags as $tag)
                                    <span class="badge badge-secondary">{{ $tag }}</span>
                                @endforeach
                            @endif
                        </td>
                        <td>{{ $post->user->name ?? 'No especificado' }}</td>
                        <td>{{ $post->category->name ?? 'Sin categoría' }}</td>
                        <td>
                            @if($post->status == 'published')<span class="badge badge-success">Publicado</span>
                            @elseif($post->status == 'draft')<span class="badge badge-secondary">Borrador</span>
                            @else<span class="badge badge-warning">Archivado</span>
                            @endif
                        </td>
                        <td>{{ $post->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay posts para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
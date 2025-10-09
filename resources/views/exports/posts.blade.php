<table>
    <thead>
        <tr>
            <th style="font-weight: bold; background-color: #ff0000;">ID</th>
            <th style="font-weight: bold;">Título</th>
            <th style="font-weight: bold;">Categoría</th>
            <th style="font-weight: bold;">Autor</th>
            <th style="font-weight: bold;">Estado</th>
            <th style="font-weight: bold;">Fecha de Creación</th>
        </tr>
    </thead>
    <tbody>
    @foreach($posts as $post)
        <tr>
            <td>{{ $post->id }}</td>
            <td>{{ $post->title }}</td>
            <td>{{ $post->category->name ?? 'N/A' }}</td>
            <td>{{ $post->user->name ?? 'N/A' }}</td>
            <td>{{ ucfirst($post->status) }}</td>
            <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
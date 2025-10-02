@extends('adminlte::page')

@section('title', 'Editar Post')

@section('content_header')
    <h1>Editar Post: {{ $post->title }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Título --}}
                <div class="form-group">
                    <label for="title">Título:</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $post->title) }}" required>
                    @error('title')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>

                {{-- Categoría --}}
                <div class="form-group">
                    <label for="category_id">Categoría:</label>
                    <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>

                {{-- Contenido --}}
                <div class="form-group">
                    <label for="content">Contenido:</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="6" required>{{ old('content', $post->content) }}</textarea>
                    @error('content')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>
                
                {{-- Imagen Principal --}}
                <div class="form-group">
                    <label for="image">Imagen Principal</label>
                    @if($post->image_path)
                    <div class="mb-2"><img src="{{ asset('storage/' . $post->image_path) }}" alt="Imagen actual" style="width: 150px; border-radius: 5px;"></div>
                    @endif
                    <div class="custom-file">
                        <input type="file" accept="image/*" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image">
                        <label class="custom-file-label" for="image">Elegir nuevo archivo...</label>
                    </div>
                    @error('image')<span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>

                <div class="row">
                    {{-- Estado --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status">Estado:</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Borrador</option>
                                <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Publicado</option>
                                <option value="archived" {{ old('status', $post->status) == 'archived' ? 'selected' : '' }}>Archivado</option>
                            </select>
                            @error('status')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>
                    
                    {{-- Fecha de Registro Manual --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="manual_created_at">Fecha de Registro Manual:</label>
                            <input type="datetime-local" class="form-control @error('manual_created_at') is-invalid @enderror"
                                   id="manual_created_at" name="manual_created_at"
                                   value="{{ old('manual_created_at', optional($post->manual_created_at)->format('Y-m-d\TH:i:s')) }}">
                                                                                                                {{-- 2025-10-01T08:10 --}}
                            @error('manual_created_at')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>

                    {{-- Fecha de Publicación (Condicional) --}}
                    <div class="col-md-4">
                        <div class="form-group" id="published_at_group" style="display: none;">
                            <label for="published_at">Fecha de Publicación:</label>
                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                   id="published_at" name="published_at"
                                   value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}">
                            @error('published_at')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>
                </div>

                {{-- Is Featured --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">¿Es destacado?</label>
                            </div>
                            @error('is_featured')<span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>
                </div>

                {{-- Tags --}}
                <div class="form-group">
                    <label for="tags">Tags (separados por comas):</label>
                    <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags" value="{{ old('tags', implode(', ', $post->tags ?? [])) }}">
                    @error('tags')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>
                
                <hr>
                
                {{-- SECCIÓN DE DATOS COMPLEJOS --}}
                <h5 class="mt-4">Datos Adicionales</h5>

                {{-- Información del Autor --}}
                <div class="card card-outline card-info">
                    <div class="card-header"><h3 class="card-title">Información del Autor</h3></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="author_name">Nombre del Autor</label>
                                <input type="text" name="author_info[name]" id="author_name" class="form-control" value="{{ old('author_info.name', $post->author_info->name ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="author_role">Rol del Autor</label>
                                <input type="text" name="author_info[role]" id="author_role" class="form-control" value="{{ old('author_info.role', $post->author_info->role ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Meta Datos (Clave-Valor) --}}
                <div class="card card-outline card-warning">
                    <div class="card-header"><h3 class="card-title">Metadatos (Clave-Valor)</h3></div>
                    <div class="card-body">
                        <div id="meta-data-container">
                             @if(old('meta_data', $post->meta_data))
                                @foreach(old('meta_data', $post->meta_data) as $index => $meta)
                                <div class="row mb-2 meta-field-row">
                                    <div class="col-5">
                                        <input type="text" name="meta_data[{{ $index }}][key]" class="form-control" placeholder="Clave" value="{{ $meta['key'] ?? '' }}">
                                    </div>
                                    <div class="col-5">
                                        <input type="text" name="meta_data[{{ $index }}][value]" class="form-control" placeholder="Valor" value="{{ $meta['value'] ?? '' }}">
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-danger remove-meta-field">Eliminar</button>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" id="add-meta-field" class="btn btn-sm btn-secondary mt-2">Agregar Metadato</button>
                    </div>
                </div>

                {{-- Galería de Imágenes --}}
                <div class="card card-outline card-success">
                    <div class="card-header"><h3 class="card-title">Galería de Imágenes</h3></div>
                    <div class="card-body">
                         <div class="custom-file">
                            <input type="file" class="custom-file-input" name="gallery_images[]" id="gallery_images" multiple accept="image/*">
                            <label class="custom-file-label" for="gallery_images">Agregar más imágenes...</label>
                        </div>
                        @if ($post->gallery_images)
                        <div class="mt-3">
                            <p>Imágenes actuales:</p>
                            <div class="row">
                            @foreach ($post->gallery_images as $image)
                                <div class="col-md-2"><img src="{{ asset('storage/' . $image) }}" class="img-thumbnail"></div>
                            @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <hr>
                <button type="submit" class="btn btn-primary">Actualizar Post</button>
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Script para nombres de archivo en input file
    $('.custom-file-input').on('change', function(event) {
        let files = event.target.files;
        if (files.length > 1) {
            $(this).next('.custom-file-label').html(files.length + ' archivos seleccionados');
        } else if (files.length == 1) {
            $(this).next('.custom-file-label').html(files[0].name);
        }
    });

    // Lógica para el campo de fecha de publicación
    const statusSelect = $('#status');
    const publishedAtGroup = $('#published_at_group');
    const publishedAtInput = $('#published_at');

    function togglePublishedAt() {
        if (statusSelect.val() === 'published') {
            publishedAtGroup.slideDown();
            if (!publishedAtInput.val()) {
                const now = new Date();
                now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                publishedAtInput.val(now.toISOString().slice(0, 16));
            }
        } else {
            publishedAtGroup.slideUp();
        }
    }
    statusSelect.on('change', togglePublishedAt);
    togglePublishedAt(); // Ejecutar al cargar

    // Lógica para metadatos dinámicos
    let metaIndex = {{ count(old('meta_data', $post->meta_data ?? [])) }};
    $('#add-meta-field').click(function() {
        $('#meta-data-container').append(`
            <div class="row mb-2 meta-field-row">
                <div class="col-5">
                    <input type="text" name="meta_data[${metaIndex}][key]" class="form-control" placeholder="Clave">
                </div>
                <div class="col-5">
                    <input type="text" name="meta_data[${metaIndex}][value]" class="form-control" placeholder="Valor">
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-danger remove-meta-field">Eliminar</button>
                </div>
            </div>
        `);
        metaIndex++;
    });

    $('#meta-data-container').on('click', '.remove-meta-field', function() {
        $(this).closest('.meta-field-row').remove();
    });
});
</script>
@stop
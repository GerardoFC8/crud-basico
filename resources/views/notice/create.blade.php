@extends('adminlte::page')

@section('title', 'Crear Noticia')

@section('content_header')
    <h1>Crear Nueva Noticia</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('notices.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- Título --}}
                <div class="form-group">
                    <label for="title">Título:</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"  placeholder="Ingrese el título de la noticia" required>
                    @error('title')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>

                <div class="form-group">
                    <label for="title">Slug:</label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}" placeholder="Ingrese el título de la noticia" required>
                    @error('slug')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>

                {{-- Categoría --}}
                <div class="form-group">
                    <label for="category_id">Categoría:</label>
                    <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                        <option value="">Seleccione una categoría</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>

                {{-- Resumen --}}
                <div class="form-group">
                    <label for="summary">Resumen:</label>
                    <textarea class="form-control @error('summary') is-invalid @enderror" id="summary" name="summary" rows="3" placeholder="Escriba un resumen breve de la noticia" required>{{ old('summary') }}</textarea>
                    @error('summary')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>

                {{-- Contenido --}}
                <div class="form-group">
                    <label for="content">Contenido:</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="8" placeholder="Escriba el contenido completo de la noticia" required>{{ old('content') }}</textarea>
                    @error('content')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>

                {{-- Imagen --}}
                <div class="form-group">
                    <label for="image">Imagen</label>
                    {{-- <div class="custom-file">
                        <input type="file" accept="image/*" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image">
                        <label class="custom-file-label" for="image">Elegir archivo...</label>
                    </div> --}}
                    <input type="text" name="image" id="image" class="form-control @error('image') is-invalid @enderror" placeholder="URL de la imagen" value="{{ old('image') }}">
                     @error('image')<span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>

                <div class="row">
                    {{-- Estado --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Estado:</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Borrador</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publicado</option>
                                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archivado</option>
                            </select>
                            @error('status')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>

                    {{-- Fecha de Publicación (Condicional) --}}
                    <div class="col-md-6">
                        <div class="form-group" id="published_at_group" style="display: none;">
                            <label for="published_at">Fecha de Publicación:</label>
                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                   id="published_at" name="published_at" value="{{ old('published_at') }}">
                            @error('published_at')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>
                </div>

                 {{-- Fuente --}}
                <div class="form-group">
                    <label for="source">Fuente (URL):</label>
                    <input type="text" class="form-control @error('source') is-invalid @enderror" id="source" name="source" value="{{ old('source') }}" placeholder="https://ejemplo.com/noticia-original">
                    @error('source')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>

                {{-- Tags --}}
                <div class="form-group">
                    <label for="tags">Tags (separados por comas):</label>
                    <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags" value="{{ old('tags') }}" placeholder="tecnologia, laravel, php">
                    @error('tags')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>

                <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                <hr>
                <button type="submit" class="btn btn-primary">Guardar Noticia</button>
                <a href="{{ route('notices.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Script para mostrar el nombre del archivo en el input
    $('.custom-file-input').on('change', function(event) {
        let fileName = event.target.files[0].name;
        $(this).next('.custom-file-label').html(fileName);
    });

    // Lógica para mostrar/ocultar fecha de publicación
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
    togglePublishedAt(); // Ejecutar al cargar la página
});
</script>
@stop

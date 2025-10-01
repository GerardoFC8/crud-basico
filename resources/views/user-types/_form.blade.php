@csrf
<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $userType->name ?? '') }}" required>
    @error('name')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="description">Descripción</label>
    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $userType->description ?? '') }}</textarea>
    @error('description')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

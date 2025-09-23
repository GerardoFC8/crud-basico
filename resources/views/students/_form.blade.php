@csrf
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="nombres" class="form-label">Nombres</label>
        <input type="text" name="nombres" id="nombres" value="{{ old('nombres', $student->nombres ?? '') }}" required class="form-control @error('nombres') is-invalid @enderror">
        @error('nombres') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="correo" class="form-label">Correo</label>
        <input type="email" name="correo" id="correo" value="{{ old('correo', $student->correo ?? '') }}" required class="form-control @error('correo') is-invalid @enderror">
        @error('correo') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="cedula" class="form-label">Cédula</label>
        <input type="text" name="cedula" id="cedula" value="{{ old('cedula', $student->cedula ?? '') }}" required class="form-control @error('cedula') is-invalid @enderror">
        @error('cedula') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="edad" class="form-label">Edad</label>
        <input type="number" name="edad" id="edad" value="{{ old('edad', $student->edad ?? '') }}" class="form-control @error('edad') is-invalid @enderror">
        @error('edad') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="telefono" class="form-label">Teléfono</label>
        <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $student->telefono ?? '') }}" class="form-control @error('telefono') is-invalid @enderror">
        @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="status" class="form-label">Estado</label>
        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
            <option value="activo" @selected(old('status', $student->status ?? '') == 'activo')>Activo</option>
            <option value="inactivo" @selected(old('status', $student->status ?? '') == 'inactivo')>Inactivo</option>
            <option value="graduado" @selected(old('status', $student->status ?? '') == 'graduado')>Graduado</option>
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-12 mb-3">
        <label for="direccion" class="form-label">Dirección</label>
        <textarea name="direccion" id="direccion" rows="3" class="form-control @error('direccion') is-invalid @enderror">{{ old('direccion', $student->direccion ?? '') }}</textarea>
        @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
<div class="d-flex justify-content-end mt-3">
    <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary ms-2">
        Guardar
    </button>
</div>

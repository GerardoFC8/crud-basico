<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="first_name">Nombres:</label>
            <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $student->first_name ?? '') }}" class="form-control">
            @error('first_name') <p class="text-danger">{{ $message }}</p> @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="last_name">Apellidos:</label>
            <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $student->last_name ?? '') }}" class="form-control">
            @error('last_name') <p class="text-danger">{{ $message }}</p> @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email', $student->email ?? '') }}" class="form-control">
            @error('email') <p class="text-danger">{{ $message }}</p> @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="phone">Teléfono:</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $student->phone ?? '') }}" class="form-control">
            @error('phone') <p class="text-danger">{{ $message }}</p> @enderror
        </div>
    </div>
</div>
<hr>
<h5>Credenciales de Acceso</h5>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" class="form-control" @if(!isset($student)) required @endif>
            @if(isset($student))<small class="form-text text-muted">Dejar en blanco para no cambiar.</small>@endif
            @error('password') <p class="text-danger">{{ $message }}</p> @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="password_confirmation">Confirmar Contraseña:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" @if(!isset($student)) required @endif>
        </div>
    </div>
</div>
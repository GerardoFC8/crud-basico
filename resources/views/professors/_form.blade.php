<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" name="name" id="name" value="{{ old('name', $professor->name ?? '') }}" class="form-control" required>
    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" value="{{ old('email', $professor->email ?? '') }}" class="form-control" required>
    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="password">Contraseña</label>
    <input type="password" name="password" id="password" class="form-control" @if(!isset($professor)) required @endif>
    @if(isset($professor))<small class="form-text text-muted">Dejar en blanco para no cambiar la contraseña.</small>@endif
    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="password_confirmation">Confirmar Contraseña</label>
    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" @if(!isset($professor)) required @endif>
</div>

<div class="form-group">
    <label>Roles</label>
    @foreach ($roles as $role)
        <div class="form-check">
            <input type="checkbox" name="roles[]" id="role_{{ $role->id }}" value="{{ $role->name }}" class="form-check-input" 
            @if(isset($professor) && $professor->hasRole($role->name)) checked @endif>
            <label for="role_{{ $role->id }}" class="form-check-label">{{ $role->name }}</label>
        </div>
    @endforeach
</div>
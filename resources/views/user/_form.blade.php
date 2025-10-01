@csrf
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name ?? '') }}" required>
            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email ?? '') }}" required>
            @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" {{ isset($user) ? '' : 'required' }}>
            @if(isset($user))<small class="text-muted">Dejar en blanco para no cambiar</small>@endif
            @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="password_confirmation">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="user_type_id">Tipo de Usuario</label>
            <select name="user_type_id" id="user_type_id" class="form-control @error('user_type_id') is-invalid @enderror" required>
                <option value="">Seleccione un tipo</option>
                @foreach($userTypes as $type)
                    <option value="{{ $type->id }}" {{ old('user_type_id', $user->user_type_id ?? '') == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
            @error('user_type_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<div class="form-group">
    <h5>Roles</h5>
    @foreach($roles as $role)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}"
                @if(isset($user) && $user->hasRole($role->name)) checked @endif
                @if(is_array(old('roles')) && in_array($role->name, old('roles'))) checked @endif
            >
            <label class="form-check-label" for="role_{{ $role->id }}">
                {{ $role->name }}
            </label>
        </div>
    @endforeach
</div>

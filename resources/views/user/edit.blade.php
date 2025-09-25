@extends('adminlte::page')

@section('title', 'Asignar Roles y Permisos')

@section('content_header')
    <h1>Asignar Roles y Permisos a: {{ $user->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <h5>Roles</h5>
                    @foreach($roles as $role)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}"
                                {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                            <label class="form-check-label" for="role_{{ $role->id }}">
                                {{ $role->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                
                <hr>

                <div class="form-group">
                    <h5>Permisos Directos</h5>
                    <p class="text-muted">Asigna permisos adicionales. Los permisos heredados de roles están marcados y deshabilitados.</p>
                    <div class="row">
                        @foreach($permissions as $permission)
                            @php
                                // Verifica si el permiso viene de un rol
                                $hasPermissionViaRole = $permissionsViaRoles->contains('id', $permission->id);
                                // Verifica si el permiso es directo (usando el nombre del permiso)
                                $hasDirectPermission = $user->hasDirectPermission($permission->name);
                            @endphp
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="permissions[]" 
                                           value="{{ $permission->id }}" 
                                           id="permission_{{ $permission->id }}"
                                           {{ ($hasDirectPermission || $hasPermissionViaRole) ? 'checked' : '' }}
                                           {{ $hasPermissionViaRole ? 'disabled' : '' }}>
                                    
                                    <label class="form-check-label {{ $hasPermissionViaRole ? 'text-muted' : '' }}" for="permission_{{ $permission->id }}">
                                        {{ $permission->name }}
                                        @if($hasPermissionViaRole)
                                            <small class="font-italic">(vía rol)</small>
                                        @endif
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
                <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
            </form>
        </div>
    </div>
@stop
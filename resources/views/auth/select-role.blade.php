@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('auth_header', 'Selecciona tu Rol para Ingresar')

@section('auth_body')
    <form action="{{ route('auth.store-role') }}" method="POST">
        @csrf
        <p class="login-box-msg">Tienes varios roles asignados. Por favor, elige con cuál deseas continuar a la plataforma.</p>

        <div class="form-group">
            @foreach($roles as $role)
                <div class="icheck-primary">
                    <input type="radio" name="role" id="role_{{ $role->id }}" value="{{ $role->name }}" {{ $loop->first ? 'checked' : '' }}>
                    <label for="role_{{ $role->id }}">
                        {{ $role->name }}
                    </label>
                </div>
            @endforeach
            @error('role')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-block btn-primary">
            <span class="fas fa-sign-in-alt"></span>
            Ingresar
        </button>
    </form>
@stop

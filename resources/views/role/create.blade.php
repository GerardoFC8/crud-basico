@extends('adminlte::page')

@section('title', 'Crear Rol')

@section('content_header')
    <h1>Crear Nuevo Rol</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Nombre del Rol</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="guard_name_select">Guard Name</label>
                    <select name="guard_name" id="guard_name_select" class="form-control @error('guard_name') is-invalid @enderror">
                        @foreach ($guards as $guard)
                            <option value="{{ $guard }}" {{ old('guard_name') == $guard ? 'selected' : '' }}>{{ ucfirst($guard) }}</option>
                        @endforeach
                    </select>
                     @error('guard_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Permisos</label>
                    <div class="permissions-container mt-2">
                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="col-md-4">
                                    <div class="form-check permission-item" data-guard="{{ $permission->guard_name }}">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}">
                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Rol</button>
            </form>
        </div>
    </div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        function filterPermissions() {
            var selectedGuard = $('#guard_name_select').val();
            $('.permission-item').closest('.col-md-4').hide();
            $('.permission-item[data-guard="' + selectedGuard + '"]').closest('.col-md-4').show();
        }

        filterPermissions();

        $('#guard_name_select').on('change', function() {
            filterPermissions();
        });
    });
</script>
@stop
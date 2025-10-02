<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            // Si no hay un rol activo en la sesión, no hacemos nada y
            // dejamos que Spatie trabaje de forma normal.
            if (!session()->has('active_role_id')) {
                return null;
            }

            // --- LÍNEA PROBLEMÁTICA ELIMINADA ---
            // Ya no verificamos si el usuario es 'Admin' aquí,
            // para forzar la simulación del rol seleccionado.

            try {
                // Buscamos el rol activo.
                $activeRole = Role::findById(session('active_role_id'), 'web');

                // Verificamos si el rol activo tiene el permiso requerido.
                if ($activeRole->hasPermissionTo($ability)) {
                    return true; // Si lo tiene, concedemos acceso.
                }

                // Si el rol activo NO tiene el permiso, denegamos el acceso explícitamente.
                return false;

            } catch (\Exception $e) {
                // En caso de error, denegamos por seguridad.
                return false;
            }
        });
    }
}


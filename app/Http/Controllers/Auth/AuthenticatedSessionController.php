<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Spatie\Permission\Models\Role; // <-- Importar el modelo Role

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
    
        $user = Auth::guard('web')->user();
        
        // Cargar relaciones necesarias
        $user->load('userType', 'roles');

        // LÓGICA DE REDIRECCIÓN PERSONALIZADA
        // 1. Si es tipo 'Administrador' y tiene más de un rol
        if ($user->userType && $user->userType->name === 'Administrador' && $user->roles->count() > 1) {
            // Guardamos el ID del usuario que necesita elegir rol y lo enviamos a la pantalla de selección
            $request->session()->put('auth.user_id_select_role', $user->id);
            return redirect()->route('auth.select-role');
        }

        // CAMBIO: Eliminada la redirección específica para 'Profesor' para simplificar.
        // Ahora, si no necesita seleccionar rol, siempre irá al dashboard principal.

        // 3. Redirección por defecto
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Muestra el formulario para seleccionar el rol.
     */
    public function showSelectRoleForm(Request $request): View|RedirectResponse
    {
        $userId = $request->session()->get('auth.user_id_select_role');

        if (!$userId) {
            return redirect('/');
        }
        
        $user = User::with('roles')->findOrFail($userId);

        return view('auth.select-role', ['roles' => $user->roles]);
    }

    /**
     * Guarda el rol seleccionado en la sesión y redirige al dashboard.
     */
    public function storeSelectedRole(Request $request): RedirectResponse
    {
        $userId = $request->session()->get('auth.user_id_select_role');

        if (!$userId) {
            return redirect('/');
        }

        $user = User::findOrFail($userId);

        $request->validate([
            'role' => [
                'required',
                // Asegura que el rol seleccionado sea uno que el usuario realmente tiene
                function ($attribute, $value, $fail) use ($user) {
                    if (!$user->hasRole($value)) {
                        $fail('El rol seleccionado no es válido.');
                    }
                },
            ],
        ]);

        // Buscamos el objeto Role para obtener su ID
        $selectedRole = Role::findByName($request->role, 'web');

        // Guardar el nombre y el ID del rol activo en la sesión
        $request->session()->put('active_role_name', $selectedRole->name);
        $request->session()->put('active_role_id', $selectedRole->id);

        // Limpiar la variable de sesión para que no se le pregunte de nuevo
        $request->session()->forget('auth.user_id_select_role');

        return redirect()->intended(route('dashboard', absolute: false));
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

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
        // 1. Si es tipo 'Administrativo' (o el nombre que definas) y tiene más de un rol
        if ($user->userType && $user->userType->name === 'Administrador' && $user->roles->count() > 1) {
            // Guardamos el ID del usuario que necesita elegir rol y lo enviamos a la pantalla de selección
            $request->session()->put('auth.user_id_select_role', $user->id);
            return redirect()->route('auth.select-role');
        }

        // 2. Si tiene un solo rol, intenta redirigir a un dashboard específico (opcional)
        if ($user->roles->count() === 1) {
            $roleName = $user->roles->first()->name;
            if ($roleName === 'Profesor') {
                return redirect()->route('professors.dashboard'); // Asume que tienes esta ruta
            }
            // Puedes añadir más `if` para otros roles
        }

        // 3. Redirección por defecto si no se cumplen las condiciones anteriores
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

        // Guardar el rol activo en la sesión
        $request->session()->put('active_role', $request->role);

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

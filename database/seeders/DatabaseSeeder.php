<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Professor;
use App\Models\Student;
use App\Models\UserType;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        // Limpiar usuarios de prueba anteriores para evitar duplicados
        User::whereIn('email', ['admin@example.com', 'posts@example.com'])->delete();
        Professor::where('email', 'professor@example.com')->delete();
        Student::where('email', 'student@example.com')->delete();

        $type_users = ['Administrador', 'PostsManager', 'Profesor', 'Alumno'];
        foreach ($type_users as $type) {
            UserType::firstOrCreate(['name' => $type]);
        }

        // --- Usuario Administrador ---
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'user_type_id' => UserType::where('name', 'Administrador')->first()->id,
        ]);
        $adminUser->assignRole('Admin');

        // --- Usuario Gestor de Posts ---
        $postsUser = User::factory()->create([
            'name' => 'Posts User',
            'email' => 'posts@example.com',
        ]);
        $postsUser->assignRole('PostsManager');

        // --- Usuario Profesor de Prueba ---
        $professorUser = Professor::factory()->create([
            'name' => 'Profesor Ejemplo',
            'email' => 'professor@example.com',
        ]);
        $professorUser->assignRole('Profesor');

        // --- Usuario Alumno de Prueba ---
        $studentUser = Student::create([
            'nombres' => 'Alumno',
            'email' => 'student@example.com',
            'password' => bcrypt('password'),
            'telefono' => '987654321',
            'cedula' => '123456789',
            'edad' => 20,
            'direccion' => 'Calle Falsa 123',
            'status' => 'activo',
        ]);
        $studentUser->assignRole('Alumno');
    }
}
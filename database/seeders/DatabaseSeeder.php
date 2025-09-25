<?php

namespace Database\Seeders;

use App\Models\User;
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

        User::whereIn('email', ['admin@example.com', 'posts@example.com'])->delete();

        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        
        $adminUser->assignRole('Admin');

        $postsUser = User::factory()->create([
            'name' => 'Posts User',
            'email' => 'posts@example.com',
        ]);

        $postsUser->assignRole('PostsManager');
    }
}

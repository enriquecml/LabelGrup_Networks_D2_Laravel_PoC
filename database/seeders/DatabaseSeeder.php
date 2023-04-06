<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $admin=User::create([
            'name'=>'Admin',
            'email'=>'admin@admin.prueba',
            'password'=>Str::random(10)
        ]);
        $rol_admin=Role::create([
            'name'=>'admin'
        ]);
        $admin->assignRole($rol_admin);
    }
}

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

        $moderator=User::create([
            'name'=>'Moderator',
            'email'=>'moderator@moderator.prueba',
            'password'=>Str::random(10)
        ]);

        $rol_moderator=Role::create([
            'name'=>'moderator'
        ]);
        $moderator->assignRole($rol_moderator);

        $commercial=User::create([
            'name'=>'Commercial',
            'email'=>'commercial@commercial.prueba',
            'password'=>Str::random(10)
        ]);

        $rol_commercial=Role::create([
            'name'=>'commercial'
        ]);
        $commercial->assignRole($rol_commercial);

    }
}

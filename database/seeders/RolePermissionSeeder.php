<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat permission untuk CRUD courses
        $permissions = [
            'view courses',
            'create courses',
            'edit courses',
            'delete courses',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
            ]);
        }

        // Membuat role teacher dan memberikan permission untuk CRUD courses
        $teacher = Role::create([
            'name' => 'teacher',
        ]);

        $teacher->givePermissionTo([
            'view courses',
            'create courses',
            'edit courses',
            'delete courses',
        ]);

        // Membuat role student dan memberikan permission hanya bisa melihat courses
        $student = Role::create([
            'name' => 'student',
        ]);

        $student->givePermissionTo([
            'view courses',
        ]);

        // Membuat data user super admin
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin12345'),
        ]);

        $user->assignRole('teacher');
    }
}

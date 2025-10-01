<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionAndDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perms = ['users.view','users.manage','tickets.view','tickets.update','reports.view','finance.manage'];
        foreach ($perms as $p) Permission::findOrCreate($p);

        $admin = Role::findOrCreate('admin');
        $admin->givePermissionTo($perms);

// buat user admin (UUID otomatis)
        $user = User::firstOrCreate(
            ['email' => 'admin@kampus.test'],
            ['name' => 'Admin', 'password' => bcrypt('secret123')]
        );
        $user->assignRole('admin');
    }
}
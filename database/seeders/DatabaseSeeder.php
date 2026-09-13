<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Spatie cache clear karo — ZAROORI hai
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->call([
            RoleSeeder::class,         // ← Roles
            AdminSeeder::class,        // ← Admin user
            PatnaSchoolsSeeder::class, // ← Patna schools dataset
        ]);
    }
}
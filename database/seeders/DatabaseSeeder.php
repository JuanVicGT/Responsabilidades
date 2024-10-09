<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(RolePermissionSeeder::class);

        User::factory()->create([
            'name' => 'Super Admin',
            'username' => 'admin',
            'is_active' => true,
            'is_admin' => true,
            'is_first_access' => false
        ]);
    }
}

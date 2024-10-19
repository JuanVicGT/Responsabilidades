<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
            'is_first_login' => false
        ]);

        for ($i = 0; $i < 20000; $i++) {
            $username = '';
            do {
                $username = Str::random(10);
            } while (User::where('username', $username)->exists());

            User::factory()->create([
                'username' => $username
            ]);
        }
    }
}

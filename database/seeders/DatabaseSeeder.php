<?php

namespace Database\Seeders;

use App\Models\Dependency;
use App\Models\Event;
use App\Models\Item;
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

        for ($i = 0; $i < 2000; $i++) {
            $dependency = Dependency::create([
                'name' => fake()->name()
            ]);

            $user = User::factory()->create([
                'username' => fake()->unique()->userName(),
                'dependency' => $dependency->name
            ]);

            $user->assignRole('Empleado');

            Event::create([
                'name' => fake()->name(),
                'description' => fake()->text(50),
                'start_date' => fake()->date(),
                'end_date' => fake()->date(),
                'status' => fake()->randomElement(['active', 'cancelled', 'finished']),
                'id_responsible' => $user->id
            ]);
        }

        for ($i = 0; $i < 10000; $i++) {
            Item::create([
                'code' => fake()->unique()->ean8(),
                'amount' => 1,
                'unit_value' => 1,
                'is_available' => true,
                'quantity' => 1,
                'description' => fake()->text(50)
            ]);
        }
    }
}

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

        for ($i = 0; $i < 20; $i++) {
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

        for ($i = 0; $i < 100; $i++) {
            $unit_value = fake()->randomDigitNotNull();
            $quantity = fake()->randomDigitNotNull();
            $amount = $unit_value * $quantity;

            Item::create([
                'code' => fake()->unique()->ean8(),
                'amount' => $amount,
                'unit_value' => $unit_value,
                'is_available' => true,
                'quantity' => $quantity,
                'description' => fake()->text(50),
                'observations' => fake()->text(50)
            ]);
        }
    }
}

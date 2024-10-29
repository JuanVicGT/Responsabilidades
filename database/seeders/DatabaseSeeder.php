<?php

namespace Database\Seeders;

use App\Models\Dependency;
use App\Models\Event;
use App\Models\Item;
use App\Models\Todo;
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

        $admin = User::factory()->create([
            'name' => 'Super Admin',
            'username' => 'admin',
            'is_active' => true,
            'is_admin' => true,
            'is_first_login' => false
        ]);

        for ($i = 0; $i < 100; $i++) {
            $dependency = Dependency::create([
                'name' => fake()->name()
            ]);

            $user = User::factory()->create([
                'username' => fake()->unique()->userName(),
                'dependency' => $dependency->name
            ]);

            $user->assignRole('Empleado');

            $date = date('Y-m-d', strtotime('-' . mt_rand(0, 59) . ' days'));
            $date2 = date('Y-m-d', strtotime($date . ' +' . mt_rand(0, 4) . ' days'));

            Event::create([
                'name' => fake()->name(),
                'description' => fake()->text(50),
                'start_date' => $date,
                'end_date' => $date2,
                'status' => fake()->randomElement(['active', 'cancelled', 'finished']),
                'id_responsible' => $user->id
            ]);

            $date = date('Y-m-d', strtotime('-' . mt_rand(0, 59) . ' days'));

            Todo::create([
                'name' => fake()->name(),
                'description' => fake()->text(50),
                'date' => $date,
                'hour' => fake()->time(),
                'year' => date('Y', strtotime($date)),
                'month' => date('m', strtotime($date)),
                'status' => fake()->randomElement(['not_started', 'started', 'cancelled', 'finished']),
                'id_user' => $admin->id
            ]);
        }

        for ($i = 0; $i < 500; $i++) {
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

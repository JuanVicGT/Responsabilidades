<?php

namespace Database\Factories;

use App\Utils\Enums\StatusPasswordResetRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PasswordResetRequest>
 */
class PasswordResetRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => StatusPasswordResetRequest::NotVerified
        ];
    }
}

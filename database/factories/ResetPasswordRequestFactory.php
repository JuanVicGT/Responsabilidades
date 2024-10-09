<?php

namespace Database\Factories;

use App\Utils\Enums\StatusResetPasswordRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResetPasswordRequest>
 */
class ResetPasswordRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => StatusResetPasswordRequest::NotVerified
        ];
    }
}

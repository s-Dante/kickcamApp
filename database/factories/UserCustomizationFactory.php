<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Prompts\Concerns\Fallback;

use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserCustomization>
 */
class UserCustomizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'skin_color' => fake()->hexColor(),
            'shirt_color' => fake()->hexColor(),
            'pants_color' => fake()->hexColor(),
            'avatar_setup_data' => fake()->randomElement(['hat', 'shoes', 'glass']),
            'user_id' => User::factory(),
        ];
    }
}

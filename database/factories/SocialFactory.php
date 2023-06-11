<?php

namespace Database\Factories;

use App\Models\Social;
use Illuminate\Database\Eloquent\Factories\Factory;

class SocialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Social::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Define the default state of the Social model
        return [
            'provider' => $this->faker->word, // Generate a random word as the provider
            'verified_at' => $this->faker->optional($weight = 0.5, $default = NULL)->passthrough(now()), // Generate a date/time value with a 50% chance of being null
            'social_id' => $this->faker->unique()->username, // Generate a unique username as the social ID
        ];
    }
}

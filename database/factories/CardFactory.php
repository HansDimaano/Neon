<?php

namespace Database\Factories;

use App\Models\Card;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Card::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Define the default permission array
        $permission = [
            'facebook' => true,
            'job' => Null,
            'phone' => mt_rand(0, 1),
            'rating' => mt_rand(0, 1),
        ];

        // Define the attributes of the Card model that will be generated
        return [
            'card_no' => NULL,
            'card_name' => $this->faker->optional($weight = 0.2, $default = 'job1')->word,
            'permissions' => $permission,
        ];
    }
}

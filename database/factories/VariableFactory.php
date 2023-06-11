<?php

namespace Database\Factories;

use App\Models\Variable;
use Illuminate\Database\Eloquent\Factories\Factory;

class VariableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Variable::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // Empty definition, no attributes are defined
        ];
    }
}

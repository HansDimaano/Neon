<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Define the default state of the User model
        return [
            'fname' => $this->faker->firstName(), // Generate a random first name
            'lname' => $this->faker->lastName(), // Generate a random last name
            'email' => $this->faker->unique()->safeEmail(), // Generate a unique and safe email address
            'email_verified_at' => now(), // Set the email verification timestamp to the current time
            'username' => $this->faker->unique()->username, // Generate a unique username
            'phone' => $this->faker->numerify('###-###-####'), // Generate a random phone number in the format ###-###-####
            'password' => Hash::make('adminx'), // Hash the password 'adminx' using the Hash facade
            'remember_token' => Str::random(10), // Generate a random remember token
            'bio' => $this->faker->text, // Generate a random text for the bio
            'views' => \mt_rand(55,5000), // Generate a random number of views between 55 and 5000
            'rate_counter' => \mt_rand(50,100), // Generate a random rate counter between 50 and 100
            'total_rating' => \mt_rand(75,250), // Generate a random total rating between 75 and 250
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        // Define a state for the User model where the email_verified_at attribute is null
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}

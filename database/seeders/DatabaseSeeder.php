<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Card;
use App\Models\Favourite;
use App\Models\Follow;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Uncomment the following line if you want to use the User factory to create 10 users
        // \App\Models\User::factory(10)->create();

        $total_user = 30;

        if (true) {
            // Iterate over the number of users
            for ($user_i = 0; $user_i < $total_user; $user_i++) {
                if ($user_i == 0) {
                    // Create a specific user with predefined values
                    $user = User::factory()->create([
                        'fname' => 'S Islam',
                        'lname' => 'Rafi',
                        'email' => 'sislamrafi333@gmail.com',
                        'phone' => '01832827201',
                        'username' => 'sislamrafi',
                        'remember_token' => "EHnzoXu4xZROC3kBLPPZm40iSFzBFXfwaublJDMAYYjs2IAAP2zoJ1a05Qhu",
                    ]);
                } else {
                    // Create a random user
                    $user = User::factory()->create();
                }

                // Iterate over the number of cards per user
                for ($card_i = 0; $card_i < mt_rand(1, 3); $card_i++) {
                    if ($card_i == 0) {
                        // Create a specific card for the user with predefined values
                        $card = Card::factory()->create([
                            'user_id' => $user->id,
                            'card_name' => 'public',
                        ]);
                    } else {
                        // Create a random card for the user
                        $card = Card::factory()->create([
                            'user_id' => $user->id,
                        ]);
                    }
                }
            }
        }

        // Call other seeders
        $this->call([
            \Database\Seeders\FollowSeeder::class,
            \Database\Seeders\FavouriteSeeder::class,
            \Database\Seeders\SocialSeeder::class,
            \Database\Seeders\VariableSeeder::class,
        ]);
    }
}

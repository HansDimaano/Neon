<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Card;
use App\Models\Favourite;
use App\Models\Follow;

class FollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();

        // Get all cards
        $cards = Card::all();

        // Get the IDs of all users
        $ids = User::pluck('id')->all();
        $total_user = count($ids);
        $out->writeln('User :' . json_encode($ids));
        $out->writeln('Total User : ' . $total_user);
        
        foreach ($cards as $card) {
            $user = $card->user;
            $arr = array($user->id);

            // Iterate a random number of times (1 to 5) to create follows for the card
            for ($fav_i = 0; $fav_i < mt_rand(1, 5); $fav_i++) {
                // Generate a random user ID that is not already in the $arr array
                while (in_array(($n_id = mt_rand(1, $total_user-1)), $arr));
                
                // Create a follow using the factory
                $fav = Follow::factory()->create([
                    'follow_id' => $ids[$n_id],
                    'card_id' => $card->id,
                ]);

                // Add the user ID to the $arr array to prevent duplicate follows
                array_push($arr, $n_id);
            }
        }
    }
}

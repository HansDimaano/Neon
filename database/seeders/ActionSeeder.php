<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Card;
use App\Models\Favourite;
use App\Models\Follow;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a new instance of ConsoleOutput
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();

        // Get all cards
        $cards = Card::all();

        // Get the IDs of all users
        $ids = User::pluck('id')->all();
        $total_user = count($ids);

        // Output the user IDs and total number of users
        $out->writeln('User: ' . json_encode($ids));
        $out->writeln('Total User: ' . $total_user);

        // Iterate over each card
        foreach ($cards as $card) {
            $user = $card->user;
            $arr = array($user->id);

            // Generate random favorites
            for ($fav_i = 0; $fav_i < mt_rand(1, 5); $fav_i++) {
                while (in_array(($n_id = mt_rand(0, $total_user - 1)), $arr))
                    ;
                $fav = Favourite::factory()->create([
                    'user_id' => $ids[$n_id],
                    'card_id' => $card->id,
                ]);
                array_push($arr, $n_id);
            }

            $arr = array($user->id);

            // Generate random follows
            for ($fav_i = 0; $fav_i < mt_rand(1, 5); $fav_i++) {
                while (in_array(($n_id = mt_rand(1, $total_user - 1)), $arr))
                    ;
                $fav = Follow::factory()->create([
                    'follow_id' => $ids[$n_id],
                    'card_id' => $card->id,
                ]);
                array_push($arr, $n_id);
            }
        }
    }
}

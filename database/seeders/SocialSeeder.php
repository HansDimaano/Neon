<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Social;

class SocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        
        // Get the IDs of all users
        $ids = User::pluck('id')->all();
        $users = User::all();
        $total_user = count($ids);
        $out->writeln('User :' . json_encode($ids));
        $out->writeln('Total User : ' . $total_user);
        
        foreach ($users as $user) {
            // Create a social entry with the user's ID and provider set as 'Facebook'
            Social::factory()->create([
                'user_id' => $user->id,
                'provider' => 'Facebook',
            ]);

            // Randomly decide whether to create a social entry for other providers
            if (mt_rand(0, 1)) {
                Social::factory()->create([
                    'user_id' => $user->id,
                    'provider' => 'Github',
                ]);
            }

            if (mt_rand(0, 1)) {
                Social::factory()->create([
                    'user_id' => $user->id,
                    'provider' => 'Twitter',
                ]);
            }

            if (mt_rand(0, 1)) {
                Social::factory()->create([
                    'user_id' => $user->id,
                    'provider' => 'Instagram',
                ]);
            }

            if (mt_rand(0, 1)) {
                Social::factory()->create([
                    'user_id' => $user->id,
                    'provider' => 'Dribble',
                ]);
            }
        }
    }
}

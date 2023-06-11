<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Variable;

class VariableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // List of social providers
        $socials = array('Facebook','Twitter','Instagram','Linkdin','Whatsapp','Website','Github');
        
        // Map of provider icons, links, and hrefs
        $icon_herf_pack = [
            'Facebook' => [
                'provider'=>'Social',
                'link'=>'https://www.facebook.com',
                'icon'=> 'fa-facebook',
                'href'=>null,
            ],
            'Twitter' => [
                'provider'=>'Social',
                'link'=>'https://www.twitter.com',
                'icon'=> 'fa-twitter ',
                'href'=>null,
            ],
            'Instagram' => [
                'provider'=>'Social',
                'link'=>'https://www.instagram.com',
                'icon'=> 'fa-instagram',
                'href'=>null,
            ],
            'Whatsapp' => [
                'provider'=>'Social',
                'link'=>'https://www.whatsapp.com',
                'icon'=> 'fa-whatsapp',
                'href'=>null,
            ],
            'Website' => [
                'provider'=>'Social',
                'link'=>null,
                'icon'=> 'fa-globe',
                'href'=>'',
            ],
            'Github' => [
                'provider'=>'Social',
                'link'=>'https://www.github.com',
                'icon'=> 'fa-git',
                'href'=>null,
            ],
            'email' => [
                'provider'=>'User',
                'link'=>'https://www.instagram.com',
                'icon'=> 'fa-envelope-o',
                'href'=>'mailto:',
            ],
            'phone' => [
                'provider'=>'User',
                'link'=>null,
                'icon'=> 'fa-phone',
                'href'=>'tel:',
            ],
        ];

        // Check if the 'provider_map' variable already exists in the database
        $providerMap = Variable::where('name', 'provider_map')->get()->first();

        if (is_null($providerMap)) {
            // If 'provider_map' doesn't exist, create a new Variable entry with the name 'provider_map' and the icon_herf_pack value
            Variable::factory()->create([
                'name' => 'provider_map',
                'value' => json_encode($icon_herf_pack),
            ]);
        } else {
            // If 'provider_map' exists, update its value with the icon_herf_pack value
            $providerMap->value = json_encode($icon_herf_pack);
            $providerMap->save();
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use auth;

class ArtisanController extends Controller
{
    //
    public function artisan(Request $req)
    {
        if ($req->password != 'fami123' xor (Schema::hasTable('users') && Auth::check()&&Auth::user()->email == 'sislamrafi333@gmail.com')) {
            return redirect()->back()->with('output', 'Password Error')->withInput();
        }
        $output = [];

        if ($req->command == 'migrate --passport') {
            $output = $this->passportMigrate();
        } else {
            \Artisan::call($req->command, $output);
            $output = \Artisan::output();
        }
        return redirect()->back()->with('output', $output)->withInput();
    }

    private function passportMigrate()
    {
        \Artisan::call('migrate', ['--path' => 'vendor/laravel/passport/database/migrations']);
        return \Artisan::output();
    }
}

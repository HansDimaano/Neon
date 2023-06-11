<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Auth; // Importing the Auth facade

class Social extends Model
{
    use HasFactory;

    // The $fillable property specifies the attributes that are mass assignable.
    protected $fillable = [
        'user_id',
        'provider',
        'social_id',
        'verified_at',
    ];

    /**
     * Get the social ID by provider.
     *
     * @param  mixed  $user
     * @param  string  $provider
     * @param  string  $keyX
     * @return string|null
     */
    public static function getSocialIdByProvider($user, $provider, $keyX)
    {
        if ($provider == 'Social') {
            if (!is_null($user->socials($keyX))) {
                return empty($user->socials($keyX)->social_id) ? null : $user->socials($keyX)->social_id;
            }
            return null;
        }
        if ($provider == 'User') {
            return isset($user[$keyX]) ? $user[$keyX] : null;
        }
    }
}

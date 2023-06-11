<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Card;
use App\Models\Follow;
use App\Models\Social;

class User extends Authenticatable //implements  MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'phone',
        'username',
        'password',
        'views',
        'rate_counter',
        'total_rating',
        'remember_token',
        'bio',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user's profile picture.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profilePicture()
    {
        return $this->hasOne('App\Models\Image', 'belongs_id')->where('belongs', 'USR');
    }

    /**
     * Get the ratings given by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings()
    {
        return $this->hasMany('App\Models\Rating', 'to_id');
    }

    /**
     * Get the user's favorites.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favourites()
    {
        return $this->hasMany('App\Models\Favourite', 'user_id');
    }

    /**
     * Get the user's followers.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function followers()
    {
        $ids = $this->card()->orderBy('id', 'ASC')->pluck('id')->all(); // Target user's card list
        $card = Follow::whereIn('card_id', $ids)->orderBy('created_at', 'DESC');
        return $card;
    }

    /**
     * Get the follower with the specified card ID.
     *
     * @param  int  $card_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function follower($card_id)
    {
        $card = Follow::where('card_id', $card_id)->orderBy('created_at', 'DESC');
        return $card;
    }

    /**
     * Get the users that the user is following.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function following()
    {
        return $this->hasMany('App\Models\Follow', 'follow_id');
    }

    /**
     * Get the user's cards.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function card()
    {
        return $this->hasMany('App\Models\Card', 'user_id');
    }

    /**
     * Get the user's statuses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function status()
    {
        return $this->hasMany('App\Models\Status', 'user_id')->orderBy('id', 'desc');
    }

    /**
     * Return the protected profile card of a user.
     *
     * @param  int  $id
     * @return \App\Models\Card|null
     */
    public function returnProtectedProfileCard($id)
    {
        $ids = $this->card()->orderBy('id', 'ASC')->pluck('id')->all(); // Target user's card list

        if ($ids == NULL)
            return NULL; // "No cards in profile"

        $card = Follow::whereIn('card_id', $ids)->where('follow_id', $id)->orderBy('updated_at', 'DESC')->get()->first();

        $card = $card == NULL ? Card::find($ids[0]) : $card->card;

        return $card;
    }

    /**
     * Get the user's social media accounts.
     *
     * @param  string|null  $social
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Relations\HasOne|null
     */
    public function socials($social = NULL)
    {
        if ($social == NULL)
            return $this->hasMany('App\Models\Social', 'user_id');
        else {
            return $this->hasOne('App\Models\Social', 'user_id')->where('socials.provider', $social)->get()->first();
        }
    }
}

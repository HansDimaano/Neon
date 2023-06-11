<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = "status";

    protected $fillable = [
        'user_id',
        'body',
    ];

    /**
     * Get the user associated with the status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Get the comments associated with the status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'status_id');
    }

    /**
     * Get the likes associated with the status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany('App\Models\StatusLike', 'status_id');
    }

    /**
     * Get the tags associated with the status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        return $this->hasMany('App\Models\StatusTag', 'status_id');
    }

    /**
     * Check if the status is liked by the given user.
     *
     * @param  mixed  $user
     * @return int
     */
    public function isLikedBy($user)
    {
        return $this->hasMany('App\Models\StatusLike', 'status_id')->where('user_id', $user->id)->count();
    }

    /**
     * Get the image associated with the status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function image()
    {
        return $this->hasOne('App\Models\Image', 'belongs_id')->where('belongs', 'STA');
    }
}

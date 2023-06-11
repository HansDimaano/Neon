<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    // The $fillable property specifies the attributes that are mass assignable.
    protected $fillable = [
        'from_id',
        'to_id',
        'comment',
        'rating',
        'is_pinned',
    ];

    /**
     * Define a one-to-one relationship with the User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function from()
    {
        return $this->hasOne('App\Models\User', 'id', 'from_id');
    }
}

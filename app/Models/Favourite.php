<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;

    // The $fillable property specifies the attributes that are mass assignable.
    protected $fillable = [
        'user_id',
        'card_id',
    ];

    // The user() method defines a relationship between the Favourite model and the User model.
    public function user()
    {
        // The Favourite model belongs to a User model, using the 'belongsTo' relationship.
        // The 'App\Models\User' parameter specifies the related model class.
        // The 'user_id' parameter specifies the foreign key column in the 'favourites' table.
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    // The card() method defines a relationship between the Favourite model and the Card model.
    public function card()
    {
        // The Favourite model belongs to a Card model, using the 'belongsTo' relationship.
        // The 'App\Models\Card' parameter specifies the related model class.
        // The 'card_id' parameter specifies the foreign key column in the 'favourites' table.
        return $this->belongsTo('App\Models\Card', 'card_id');
    }
}

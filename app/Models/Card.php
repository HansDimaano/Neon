<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    // The $fillable property specifies the attributes that are mass assignable.
    protected $fillable = [
        'user_id',
        'is_accepted',
        'card_no',
        'card_name',
        'permissions',
    ];

    // The $casts property allows for attribute casting to specific data types.
    protected $casts = [
        'permissions' => 'array',
    ];

    // The user() method defines a relationship between the Card model and the User model.
    public function user()
    {
        // The Card model belongs to a User model, using the 'belongsTo' relationship.
        // The 'App\Models\User' parameter specifies the related model class.
        // The 'user_id' parameter specifies the foreign key column in the 'cards' table.
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}

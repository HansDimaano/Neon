<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // The $fillable property specifies the attributes that are mass assignable.
    protected $fillable = [
        'user_id',
        'body',
        'status_id',
    ];

    // The user() method defines a relationship between the Comment model and the User model.
    public function user()
    {
        // The Comment model belongs to a User model, using the 'belongsTo' relationship.
        // The 'App\Models\User' parameter specifies the related model class.
        // The 'user_id' parameter specifies the foreign key column in the 'comments' table.
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}

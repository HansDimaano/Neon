<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    // The $primaryKey property specifies that this model does not have a primary key.
    protected $primaryKey = null;

    // The $incrementing property specifies that the primary key is not auto-incrementing.
    public $incrementing = false;

    // The $fillable property specifies the attributes that are mass assignable.
    protected $fillable = [
        'follow_id',
        'card_id',
        'is_accepted',
    ];

    // The card() method defines a relationship between the Follow model and the Card model.
    public function card()
    {
        // The Follow model belongs to a Card model, using the 'belongsTo' relationship.
        // The 'App\Models\Card' parameter specifies the related model class.
        // The 'card_id' parameter specifies the foreign key column in the 'follows' table.
        return $this->belongsTo('App\Models\Card', 'card_id');
    }

    // The user() method defines a relationship between the Follow model and the User model.
    public function user()
    {
        // The Follow model belongs to a User model, using the 'belongsTo' relationship.
        // The 'App\Models\User' parameter specifies the related model class.
        // The 'follow_id' parameter specifies the foreign key column in the 'follows' table.
        return $this->belongsTo('App\Models\User', 'follow_id');
    }
}

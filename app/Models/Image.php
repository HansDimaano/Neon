<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    // The $fillable property specifies the attributes that are mass assignable.
    protected $fillable = [
        'belongs',
        'belongs_id',
        'name',
    ];
}

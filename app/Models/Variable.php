<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'value',
    ];

    /**
     * Get the provider map.
     *
     * @return array
     */
    public static function getProviderMap()
    {
        $provider = Variable::where('name', 'provider_map')->get()->first()->value;
        return json_decode($provider, true);
    }
}

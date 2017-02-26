<?php

namespace Appstract\Multisite;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'route',
        'url',
    ];

    /*
    |--------------------------------------------------------------------------
    | Mutators
    |--------------------------------------------------------------------------
    */

    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getUrlAttribute($value)
    {
        return $value
            ? $value
            : route($this->route);
    }
}

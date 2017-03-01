<?php

namespace Appstract\Multisite;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
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

    /**
     * Get the url.
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

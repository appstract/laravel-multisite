<?php

use Appstract\Multisite\Site;
use Illuminate\Support\Facades\Config;

if (! function_exists('current_site')) {
    /**
     * Get current site.
     *
     * @return Appstract\Multisite\Site
     */
    function current_site()
    {
        $modelClass = Config::get('multisite.model', Site::class);

        return call_user_func([$modelClass, 'query'])
            ->where('slug', Config::get('multisite.site'))
            ->first();
    }
}

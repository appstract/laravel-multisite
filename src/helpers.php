<?php

use Config;
use Appstract\Multisite\Site;

if (! function_exists('current_site')) {
    /**
     * Get current site.
     *
     * @return Appstract\Multisite\Site
     */
    function current_site()
    {
        return Site::where('slug', Config::get('multisite.site'))->first();
    }
}

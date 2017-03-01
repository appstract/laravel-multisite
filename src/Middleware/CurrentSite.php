<?php

namespace Appstract\Multisite\Middleware;

use Config;
use Closure;

class CurrentSite
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $site)
    {
        Config::set('multisite.site', $site);

        return $next($request);
    }
}

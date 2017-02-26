<?php

namespace Appstract\Multisite\Middleware;

use Config;
use Closure;
use Illuminate\Support\Facades\View;

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
        Config::set('app.site', $site);

        return $next($request);
    }
}

<?php

namespace Appstract\Multisite\Composers;

use Config;
use Appstract\Multisite\Site;
use Illuminate\View\View;

class CurrentSiteComposer
{
    /**
     * Articles.
     * @var [type]
     */
    protected $site;

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->site = Site::where('nickname', Config::get('app.site'))->first();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('currentSite', $this->site);
    }
}
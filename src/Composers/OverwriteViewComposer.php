<?php

namespace Appstract\Multisite\Composers;

use Config;
use Appstract\Multisite\Site;
use Illuminate\View\View;

class OverwriteViewComposer
{
    /**
     * Articles.
     * @var [type]
     */
    protected $sites;


    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if ($this->overwriteDisabled($view)) {
            return $view;
        }

        $currentSite = Site::where('nickname', Config::get('multisite.site'))->first();

        $parts = collect(explode('/views/', $view->getPath()));

        $viewsPath    = $parts->first().'views';
        $possiblePath = $parts->first().'/views/'.$currentSite->nickname.'/'.$parts->last();
        $possibleView = str_replace(['.blade.php'], [''], $currentSite->nickname.'.'.$parts->last());

        if(\View::exists($possibleView)) {
            $view->setPath($possiblePath);
        }

        return $view;
    }

    /**
     * [overwriteDisabled description]
     * @param  [type] $view [description]
     * @return [type]       [description]
     */
    protected function overwriteDisabled($view)
    {
        return ! Config::get('multisite.overwrite.enabled') || $view->overwrite === false;
    }
}
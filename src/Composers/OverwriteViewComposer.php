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

        $currentSite = Site::where('slug', Config::get('multisite.site'))->first();

        $viewsPath = realpath(base_path('resources/views'));

        $currentPath  = collect(explode('/views/', $view->getPath()))->last();
        $possiblePath = $viewsPath.'/'.$currentSite->slug.'/'.$currentPath;
        $possibleView = str_replace(['.blade.php'], [''], $currentSite->slug.'.'.$currentPath);

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
        return ! Config::get('multisite.views.overwrite') || $view->overwrite === false;
    }
}
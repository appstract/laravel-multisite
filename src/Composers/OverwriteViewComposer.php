<?php

namespace Appstract\Multisite\Composers;

use Config;
use Illuminate\View\View;
use Appstract\Multisite\Site;

class OverwriteViewComposer
{
    /**
     * Slug of the current site.
     *
     * @var string
     */
    protected $currentSite;

    /**
     * Name of the sites folder.
     *
     * @var string
     */
    protected $sitesFolder;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->currentSite = Site::where('slug', Config::get('multisite.site'))->first();

        $this->sitesFolder = Config::get('multisite.views.sites');
    }

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

        $this->currentPath = collect(explode('/views/', $view->getPath()))->last();

        if (\View::exists($this->getNewView())) {
            $view->setPath($this->getNewPath());
        }

        return $view;
    }

    /**
     * Get the new path.
     *
     * @return string
     */
    protected function getNewPath()
    {
        return $this->getAbsolutesitesFolder().DIRECTORY_SEPARATOR.$this->currentSite->slug.DIRECTORY_SEPARATOR.$this->currentPath;
    }

    /**
     * Get the new view.
     *
     * @return string
     */
    protected function getNewView()
    {
        return str_replace(
            ['.blade.php'],
            [''],
            $this->sitesFolder.'.'.$this->currentSite->slug.'.'.$this->currentPath
        );
    }

    /**
     * Get absolute path to sites folder.
     *
     * @return string
     */
    protected function getAbsolutesitesFolder()
    {
        return base_path('resources/views'.DIRECTORY_SEPARATOR.$this->sitesFolder);
    }

    /**
     * Check if overwrites are disabled.
     *
     * @param  View $view
     * @return bool
     */
    protected function overwriteDisabled($view)
    {
        return ! Config::get('multisite.views.overwrite') || $view->overwrite === false;
    }
}

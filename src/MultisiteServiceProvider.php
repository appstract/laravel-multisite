<?php

namespace Appstract\Multisite;

use Config;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Appstract\Multisite\Middleware\CurrentSite;

class MultisiteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(Router $router)
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'database');

            $this->publishes([
                __DIR__.'/../database/seeds' => database_path('seeds'),
            ], 'database');

            $this->publishes([
                __DIR__.'/../config/multisite.php' => config_path('multisite.php'),
            ], 'config');
        }

        $this->registerMiddleware($router);

        $this->registerComposers();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // App
        $this->app->singleton(\Appstract\Multisite\Composers\CurrentSiteComposer::class);

        // Config
        $this->mergeConfigFrom(__DIR__.'/../config/multisite.php', 'multisite');
    }

    /**
     * Register middleware.
     *
     * @param  object $router
     * @return void
     */
    protected function registerMiddleware($router)
    {
        if (method_exists($router, 'aliasMiddleware')) {
            $router->aliasMiddleware('site', CurrentSite::class);
        } else {
            $router->middleware('site', CurrentSite::class);
        }
    }

    /**
     * Register view composers.
     *
     * @return void
     */
    protected function registerComposers()
    {
        View::composer(
            '*',
            \Appstract\Multisite\Composers\CurrentSiteComposer::class
        );

        View::composer(
            Config::get('multisite.views.overwriteable'),
            \Appstract\Multisite\Composers\OverwriteViewComposer::class
        );
    }
}

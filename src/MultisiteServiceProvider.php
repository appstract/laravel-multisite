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
            $this->registerMigrations();

            $this->publishes([
                __DIR__.'/../config/multisite.php' => config_path('multisite.php'),
            ], 'config');
        }

        // Middleware
        $router->aliasMiddleware('site', CurrentSite::class);

        // Composers
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
     * Register Passport's migration files.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'multisite-migrations');
    }

    /**
     * Register view composers.
     *
     * @return void
     */
    protected function registerComposers()
    {
        $overwriteViews = Config::get('multisite.views.overwriteable');

        View::composer('*', \Appstract\Multisite\Composers\CurrentSiteComposer::class);
        View::composer($overwriteViews, \Appstract\Multisite\Composers\OverwriteViewComposer::class);
    }
}

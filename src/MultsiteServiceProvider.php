<?php

namespace Appstract\Multisite;

use Config;
use Appstract\Multisite\Middleware\CurrentSite;
Use Illuminate\Routing\Router;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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

        $overwriteViews = Config::get('multisite.views.overwrite_path');

        // Middleware
        $router->aliasMiddleware('site', CurrentSite::class);

        // Composers
        View::composer('*', \Appstract\Multisite\Composers\CurrentSiteComposer::class);
        View::composer($overwriteViews, \Appstract\Multisite\Composers\OverwriteViewComposer::class);
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
     * Register the application services.
     */
    public function register()
    {
        $this->app->singleton(\Appstract\Multisite\Composers\CurrentSiteComposer::class);

        $this->mergeConfigFrom(__DIR__.'/../config/multisite.php', 'multisite');
    }
}

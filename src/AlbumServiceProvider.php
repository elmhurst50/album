<?php

namespace samjoyce777\album;

use Illuminate\Support\ServiceProvider;

class AlbumServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Album', 'samjoyce777\album\Album');

        $config = require(__DIR__.'/config/album.php');

        config($config);
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/album.php' => config_path('album.php')
        ], 'config');
    }
}

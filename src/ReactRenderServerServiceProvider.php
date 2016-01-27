<?php

namespace Tureki\RRS;

use Illuminate\Support\ServiceProvider;

class ReactRenderServerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/config.php' => config_path('react-render-server.php'),
            __DIR__ . '/config/rrs/.babelrc' => base_path('resources/assets/rrs/.babelrc'),
            __DIR__ . '/config/rrs/.env' => base_path('resources/assets/rrs/.env'),
            __DIR__ . '/config/rrs/package.json' => base_path('resources/assets/rrs/package.json'),
            __DIR__ . '/config/rrs/server.js' => base_path('resources/assets/rrs/server.js'),
            __DIR__ . '/config/rrs/src/HelloWorld.jsx' => base_path('resources/assets/rrs/src/HelloWorld.jsx'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/config.php',
            'react-render-server'
        );

        $this->app['react-render-server'] = $this->app->share(function ($app) {
            return $app->make('Tureki\RRS\ReactRenderServer');
        });
    }
}

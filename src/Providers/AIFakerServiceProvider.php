<?php

namespace Kimani\AIFaker\Providers;

use Illuminate\Support\ServiceProvider;

class AIFakerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Publish the config file
        $this->publishes([
            __DIR__ . '/../Config/aifaker.php' => config_path('aifaker.php'),
        ], 'config');
    }

    /**
     * Register services.
     */
    public function register()
    {
        // Merge the default config
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/aifaker.php', 'aifaker'
        );
    }
}

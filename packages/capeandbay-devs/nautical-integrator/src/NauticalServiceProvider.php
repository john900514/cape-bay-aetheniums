<?php

namespace AnchorCMS\Nautical;

use AnchorCMS\NauticalIntegrator\NauticalIntegrator;

class NauticalServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/../config/nautical-integrator.php';

    public function boot()
    {
        $this->loadConfigs();

        $this->publishFiles();

        $this->loadRoutes();
    }

    public function register()
    {
        $this->mergeConfigFrom(
            self::CONFIG_PATH,
            'nautical-integrator'
        );

        $this->app->bind('nautical-integrator', function () {
            return new NauticalIntegrator();
        });
    }

    public function loadConfigs()
    {
        // use the vendor configuration file as fallback
        $this->mergeConfigFrom(__DIR__.'/../config/nautical-integrator.php', 'nautical');
    }

    public function publishFiles()
    {
        $capeandbay_config_files = [__DIR__.'/config' => config_path()];

        $minimum = array_merge(
            $capeandbay_config_files
        );

        // register all possible publish commands and assign tags to each
        $this->publishes($capeandbay_config_files, 'config');
        $this->publishes($minimum, 'minimum');
    }

    public function loadRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/capeandbay/anchor-cms.php');
    }
}

<?php

namespace Bl\FatooraZatca;

use Illuminate\Support\ServiceProvider;

class FatooraZatcaServiceProvider extends ServiceProvider
{
    /**
     * the path of config file.
     *
     * @var string
     */
    private $configPath = __DIR__ . '/Config/zatca.php';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->configPath, 'zatca');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            $this->configPath => config_path('zatca.php'),
         ], 'fatoora-zatca');
    }
}

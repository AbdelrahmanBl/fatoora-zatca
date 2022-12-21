<?php

namespace Bl\FatooraZatca;

use Illuminate\Support\ServiceProvider;

class FatooraZatcaServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/zatca.php' =>  config_path('zatca.php'),
         ], 'fatoora-zatca');
    }
}

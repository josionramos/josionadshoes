<?php

namespace App\Providers;

use App\Correios\Shipping\Api;
use App\Correios\Shipping\Client;
use Illuminate\Support\ServiceProvider;

class CorreiosServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Api::class, function () {
            return new Api(new Client);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Api::class];
    }
}

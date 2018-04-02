<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\ServiceProvider;

class PassportServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Passport::routes();

        // OAUTH tokens
        Passport::tokensCan([
            'manager' => 'Can manage e-commerce',
            'customer' => 'Can buy products'
        ]);
    }
}

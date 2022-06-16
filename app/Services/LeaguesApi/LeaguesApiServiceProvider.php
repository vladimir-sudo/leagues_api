<?php

namespace App\Services\LeaguesApi;

use Illuminate\Support\ServiceProvider;

class LeaguesApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('leagues_api', function () {
            return new LeaguesApi($this->app->config['services']['leagues_api']);
        });

        $this->app->bind('leagues_api_client', LeaguesApiClient::class);
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Routing\UrlGenerator;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      if(env('REDIRECT_HTTPS')){
        $this->app['request']->server->set('HTTPS', true);
      }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        Schema::defaultStringLength(191);
        Passport::withoutCookieSerialization();
        if(env('REDIRECT_HTTPS')){
          $url->formatScheme('https');
        }
    }
}

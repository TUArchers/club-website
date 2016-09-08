<?php

namespace TuaWebsite\Providers;

use Illuminate\Support\ServiceProvider;
use TuaWebsite\Services\IdentityService;

/**
 * Identity Service Provider
 *
 * @package TuaWebsite\Providers
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class IdentityServiceProvider extends ServiceProvider
{
    /**
     * Register the application services
     */
    public function register()
    {
        $this->app->singleton(IdentityService::class, function($app){
            return new IdentityService();
        });
    }
}

<?php

namespace TuaWebsite\Providers;

use Illuminate\Support\ServiceProvider;
use TuaWebsite\Services\CalendarService;

/**
 * Calendar Service Provider
 *
 * @package TuaWebsite\Providers
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class CalendarServiceProvider extends ServiceProvider
{
    /**
     * Register the application services
     */
    public function register()
    {
        $this->app->singleton(CalendarService::class, function($app){
            return new CalendarService();
        });
    }
}

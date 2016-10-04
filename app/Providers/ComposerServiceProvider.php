<?php
namespace TuaWebsite\Providers;

use Illuminate\Support\ServiceProvider;
use TuaWebsite\Http\ViewComposers\AdminLayoutComposer;

/**
 * ComposerServiceProvider
 *
 * @package TuaWebsite\Providers
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        \View::composer('layouts.admin', AdminLayoutComposer::class);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}

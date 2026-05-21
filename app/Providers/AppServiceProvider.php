<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kernal\PluginRegistry;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        // Inside /Providers/AppServiceProvider.php register method:
          \Kernal\PluginRegistry::discoverAndRegister();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //'providers' => [

        \Kernel\KernelServiceProvider::class;

    }
}

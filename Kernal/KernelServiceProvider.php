<?php

namespace Kernal;

use Illuminate\Support\ServiceProvider;
use Kernel\EventBus\EventBus;
use Kernel\Contracts\EventBusInterface;
use Kernel\PluginRegistry;

class KernelServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            EventBusInterface::class,
            EventBus::class
        );

        $this->app->singleton(
            PluginRegistry::class,
            fn () => new PluginRegistry()
        );
    }

    public function boot(): void
    {
        app(PluginRegistry::class)
            ->discoverAndRegister();
    }
}

<?php

namespace Plugins\Auth\src\Providers;

use Illuminate\Support\ServiceProvider;

class AuthPluginServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(
            __DIR__ . '/../Routes/api.php'
        );

        $this->loadMigrationsFrom(
            base_path('plugins/Auth/database/migrations')
        );
    }
}

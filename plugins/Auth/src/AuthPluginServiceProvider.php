<?php
namespace Plugins\Auth\src;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AuthPluginServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(base_path('plugins/Auth/database/migrations'));
    }

    public function boot(): void
    {
        Route::prefix('api/v1/auth')
            ->middleware('api')
            ->group(base_path('plugins/Auth/routes/api.php'));
    }
}

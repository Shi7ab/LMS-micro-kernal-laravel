<?php
namespace plugins\Progress\src;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ProgressPluginServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Load isolated migrations for this plugin domain automatically
        $this->loadMigrationsFrom(base_path('plugins/Progress/database/migrations'));
    }

    public function boot(): void
    {
        // Load isolated routes bounded into the kernel's global routing matrix
        Route::prefix('api/v1/progress')
            ->middleware('api')
            ->group(base_path('plugins/Progress/routes/api.php'));
    }
}

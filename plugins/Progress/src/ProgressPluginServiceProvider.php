<?php
namespace plugins\Progress\src;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use plugins\Progress\src\Contracts\ProgressRepositoryInterface;
use plugins\Progress\src\Repositories\ProgressRepository;

class ProgressPluginServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Load isolated migrations for this plugin domain automatically
        $this->loadMigrationsFrom(base_path('plugins/Progress/database/migrations'));

        $this->app->bind(
            ProgressRepositoryInterface::class,
            ProgressRepository::class
        );

    }

    public function boot(): void
    {
        // Load isolated routes bounded into the kernel's global routing matrix
        Route::prefix('api/v1/progress')
            ->middleware('api')
            ->group(base_path('plugins/Progress/routes/api.php'));
    }
}

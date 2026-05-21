<?php
namespace Plugins\Enrollment\src;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class EnrollmentPluginServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Load isolated migrations for this plugin domain automatically
        $this->loadMigrationsFrom(base_path('plugins/Enrollment/database/migrations'));
    }

    public function boot(): void
    {
        // Load isolated routes bounded into the kernel's global routing matrix
        Route::prefix('api/v1/enrollments')
            ->middleware('api')
            ->group(base_path('plugins/Enrollment/routes/api.php'));
    }
}

<?php
namespace plugins\Quiz\src;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use plugins\Quiz\src\Repositories\QuizRepository;

class QuizPluginServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Load isolated migrations for this plugin domain automatically
        $this->loadMigrationsFrom(base_path('plugins/Quiz/database/migrations'));
         $this->app->bind(
            QuizRepository::class
        );
    }

    public function boot(): void
    {
        // Load isolated routes bounded into the kernel's global routing matrix
        Route::prefix('api/v1/Quizs')
            ->middleware('api')
            ->group(base_path('plugins/Quiz/routes/api.php'));
    }
}

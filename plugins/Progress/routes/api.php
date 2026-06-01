<?php

use Illuminate\Support\Facades\Route;
use plugins\Progress\src\Http\Controllers\ProgressController;

Route::middleware('jwt.auth')->group(function () {

    // Mark lesson as completed
    Route::post(
        '/lessons/{lessonId}/complete',
        [ProgressController::class, 'markAsComplete']
    );

    // Get course progress
    Route::get(
        '/courses/{courseId}',
        [ProgressController::class, 'getCourseProgress']
    );

});

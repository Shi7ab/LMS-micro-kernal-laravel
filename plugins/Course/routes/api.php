<?php

use Illuminate\Support\Facades\Route;
use plugins\Course\src\Http\Controllers\CourseController;
use plugins\Course\src\Http\Controllers\LessonController;

Route::middleware('jwt.auth')->group(function () {

    Route::prefix('courses')->group(function () {

        // Courses
        Route::post('/', [CourseController::class, 'store']);
        Route::get('/', [CourseController::class, 'index']);

        // Lessons
        Route::post(
            '/{courseId}/lessons',
            [LessonController::class, 'store']
        );

        Route::patch(
            '/{courseId}/lessons/reorder',
            [LessonController::class, 'reorder']
        );
    });

    Route::get(
        '/lessons',
        [LessonController::class, 'index']
    );

    Route::post(
        '/courses/{courseId}/publish',
        [CourseController::class, 'publish']
    );
});

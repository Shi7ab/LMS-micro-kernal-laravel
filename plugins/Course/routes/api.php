<?php

use Illuminate\Support\Facades\Route;
use plugins\Course\src\Http\Controllers\CourseController;

Route::middleware('jwt.auth')->group(function () {

  //  Route::prefix('courses')->group(function () {

        // create course
        Route::post('/', [CourseController::class, 'store']);

        // add lesson to course
        Route::post('/{courseId}/lessons', [
            CourseController::class,
            'addLesson'
        ]);

        // publish course
        Route::patch('/{courseId}/publish', [
            CourseController::class,
            'publish'
        ]);

        // reorder lessons
        Route::patch('/{courseId}/lessons/reorder', [
            CourseController::class,
            'reorderLessons'
        ]);
  //  });
});

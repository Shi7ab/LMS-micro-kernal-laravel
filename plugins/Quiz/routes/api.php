<?php

use Illuminate\Support\Facades\Route;
use plugins\Quiz\src\Http\Controllers\QuizController;
use plugins\Quiz\src\Http\Controllers\QuizSubmissionController;

Route::middleware('jwt.auth')->group(function () {

    Route::prefix('quizzes')->group(function () {

        Route::post(
            '/',
            [QuizController::class, 'store']
        );

        Route::post(
            '/{quizId}/submit',
            [QuizSubmissionController::class, 'submit']
        );
    });
});

<?php

use Illuminate\Support\Facades\Route;
use Plugins\Quiz\src\Http\Controllers\QuizController;

Route::post('/', [QuizController::class, 'store']);
Route::post('/{quizId}', [QuizController::class, 'submit']);


<?php

use Illuminate\Support\Facades\Route;
use plugins\Course\src\Http\Controllers\CourseController;

Route::post('/', [CourseController::class, 'store']);
Route::post('/lesson', [CourseController::class, 'addLesson']);
Route::put('/{id}', [CourseController::class, 'publish']);
Route::put('/{id}', [CourseController::class, 'reorderLessons']);


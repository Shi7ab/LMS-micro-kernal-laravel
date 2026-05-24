<?php
// plugins/Media/src/api.php

use Illuminate\Support\Facades\Route;
use Plugins\Media\src\Http\Controllers\MediaController;

Route::prefix('api/v1/media')->group(function () {

   // Route::middleware(['kernel.auth', 'role:instructor,admin'])->group(function () {
        Route::post('/upload', [MediaController::class, 'upload']);
    //});

 //   Route::middleware(['kernel.auth'])->group(function () {
        Route::get('/lesson/{lessonId}', [MediaController::class, 'getMediaByLesson']);
   // });
});

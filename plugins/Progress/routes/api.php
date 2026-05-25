<?php

use Illuminate\Support\Facades\Route;
use Plugins\Progress\src\Http\Controllers\ProgressController;

Route::post('/', [ProgressController::class, 'store']);
Route::post('/{progressId}', [ProgressController::class, 'submit']);


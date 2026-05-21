<?php

use Illuminate\Support\Facades\Route;
use Plugins\Enrollment\src\Http\Controllers\EnrollmentController;

Route::post('/', [EnrollmentController::class, 'enroll']);

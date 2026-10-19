<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('staff', StaffController::class);

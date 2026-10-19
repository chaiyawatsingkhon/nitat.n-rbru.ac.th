<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TitleController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ActivitiesController;

Route::get('/', function () {
    return redirect('/title');
});

Route::get('/title', [TitleController::class, 'index']);
Route::get('/staff', [StaffController::class, 'index']);
Route::get('/organization', [OrganizationController::class, 'index']);
Route::get('/community', [CommunityController::class, 'index']);
Route::get('/activities', [ActivitiesController::class, 'index']);
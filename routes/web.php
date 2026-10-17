<?php

use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// หน้าแรก (ใครก็เข้าได้)
Route::get('/', function () {
    return view('welcome');
});

// กลุ่ม Route ที่ต้องล็อกอินก่อน (auth middleware)
Route::middleware('auth')->group(function () {

    // Breeze redirect มาที่ dashboard หลังล็อกอิน -> ส่งต่อไปหน้าสูตรอาหาร
    Route::get('/dashboard', fn () => redirect()->route('recipes.index'))->name('dashboard');

    // จัดการโปรไฟล์ (มาจาก Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD สูตรอาหาร: recipes.index / create / store / show / edit / update / destroy
    Route::resource('recipes', RecipeController::class);

    // CRUD แผนมื้ออาหาร: meal-plans.index / create / store / show / edit / update / destroy
    Route::resource('meal-plans', MealPlanController::class);

    // รายงานสถิติและกราฟ
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});

require __DIR__ . '/auth.php';

<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ViewController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [ViewController::class,'auth'])->name('page.login');

// authentication
Route::post('signin', [AuthController::class,'signin'])->name('auth.signin');
Route::post('signup', [AuthController::class,'signup'])->name('auth.signup');
Route::get('signup', [ViewController::class,'register'])->name('page.register');

// auth protected routes
Route::get('user/dashboard', [ViewController::class, 'dashboard'])->middleware(AuthMiddleware::class)->name('user.dashboard');
Route::get('user/course', [ViewController::class, 'course'])->middleware(AuthMiddleware::class)->name('user.course');
Route::post('/user/course-action', [CourseController::class, 'store'])->middleware(AuthMiddleware::class)->name('user.courseAction');
Route::get('/user/course-details/{course}', [CourseController::class, 'show'])->middleware(AuthMiddleware::class)->name('user.courseDetails');

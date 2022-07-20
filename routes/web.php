<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AjaxUploadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();


Route::group(['middleware' => ['auth']], function() {
    Route::get('/', [dashboardController::class,'dash']);
    Route::resource('roles', RoleController::class)->middleware('permission:role-list');
    Route::resource('users', UserController::class)->middleware('permission:user-list');
    Route::resource('tasks', TaskController::class)->middleware('permission:task-list');
    Route::get('/download/{file}', [TaskController::class, 'download']);
    Route::get('/picdownload/{picfile}', [TaskController::class, 'picdownload']);
// new route Export
    Route::get('export', [TaskController::class, 'export_excel']);
    Route::get('/dashboard/search', [dashboardController::class, 'search']);
    Route::get('/task/search', [TaskController::class, 'search']);
    Route::get('/user/search', [UserController::class, 'search']);
    Route::get('/role/search', [RoleController::class, 'search']);

    //Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.edit');
    Route::get('/profile', [ProfileController::class,'editView']);
    Route::post('/profile', [ProfileController::class,'edit']);

    // Route::get('/profile', [AjaxUploadController::class, 'index']);
    // Route::post('/profile', [AjaxUploadController::class, 'store']);
});

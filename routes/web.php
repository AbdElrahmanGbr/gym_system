<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GymManagerController;
use App\Http\Controllers\CityManagerController;
use App\Http\Controllers\RoleController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');



// city manager
Route::controller(CityManagerController::class)->group(function () {
    Route::get('/cityManager/create', 'create')->name('cityManager.create')->middleware('auth')->middleware('role:admin');
    Route::post('/cityManager/store', 'store')->name('cityManager.store')->middleware('auth')->middleware('role:admin');
    Route::get('/cityManager/list', 'list')->name('cityManager.list')->middleware('auth')->middleware('role:admin');
    Route::get('/cityManager/edit/{id}', 'edit')->name('cityManager.edit')->middleware('auth')->middleware('role:admin');
    Route::put('/cityManager/update/{id}', 'update')->name('cityManager.update')->middleware('auth')->middleware('role:admin');
    Route::delete('/cityManager/{id}', 'deletecityManager')->name('cityManager.delete')->middleware('auth')->middleware('role:admin');
    Route::get('/cityManager/show/{id}', 'show')->name('cityManager.show')->middleware('auth')->middleware('role:admin');
});

// gym manager
Route::controller(GymManagerController::class)->group(function () {
    Route::get('/gymManager/create', 'create')->name('gymManager.create')->middleware('role:admin|cityManager');
    Route::post('/gymManager/store', 'store')->name('gymManager.store')->middleware('role:admin|cityManager');
    Route::get('/gymManager/list', 'list')->name('gymManager.list')->middleware('role:admin|cityManager');
    Route::get('/gymManager/edit/{gym}', 'edit')->name('gymManager.edit')->middleware('role:admin|cityManager');
    Route::put('/gymManager/update/{gym}', 'update')->name('gymManager.update')->middleware('role:admin|cityManager');
    Route::delete('/gymManager/{id}', 'deletegymManager')->name('gymManager.delete')->middleware('role:admin|cityManager');
    Route::get('/gymManager/show/{id}', 'show')->name('gymManager.show')->middleware('role:admin|cityManager');
});
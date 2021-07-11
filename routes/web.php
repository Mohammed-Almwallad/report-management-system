<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;

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
    return view('home');
});

Auth::routes(['register'=>false]);

Route::middleware(['auth'])->group(function () {

    // user routes
    Route::get('/users',[UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/show',[UserController::class, 'show'])->name('users.show');
    Route::get('/users/create',[UserController::class, 'create'])->name('users.create');
    Route::post('/users',[UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{id}',[UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{id}/edit',[UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}',[UserController::class, 'update'])->name('users.update');

    // groups routes
    Route::get('/groups',[GroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/{id}/show',[GroupController::class, 'show'])->name('groups.show');
    Route::get('/groups/create',[GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups',[GroupController::class, 'store'])->name('groups.store');
    Route::delete('/groups/{id}',[GroupController::class, 'destroy'])->name('groups.destroy');
    Route::get('/groups/{id}/edit',[GroupController::class, 'edit'])->name('groups.edit');
    Route::put('/groups/{id}',[GroupController::class, 'update'])->name('groups.update');


});



Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

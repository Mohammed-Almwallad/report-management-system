<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ReportController;

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

Route::middleware(['auth', 'role:admin'])->group(function () {

    // user routes
    Route::get('/users',[UserController::class, 'index'])->name('users.index');
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

    // tags routes
    Route::get('/tags',[TagController::class, 'index'])->name('tags.index');
    Route::get('/tags/create',[TagController::class, 'create'])->name('tags.create');
    Route::post('/tags',[TagController::class, 'store'])->name('tags.store');
    Route::delete('/tags/{id}',[TagController::class, 'destroy'])->name('tags.destroy');
    Route::get('/tags/{id}/edit',[TagController::class, 'edit'])->name('tags.edit');
    Route::put('/tags/{id}',[TagController::class, 'update'])->name('tags.update');
        
});

    Route::get('/reports',[ReportController::class, 'index'])->name('reports.index')->middleware('auth');
    Route::get('/reports/{id}/show',[ReportController::class, 'show'])->name('reports.show')->middleware(['auth', 'role:view-reports']);
    Route::get('/reports/create',[ReportController::class, 'create'])->name('reports.create')->middleware(['auth', 'role:create-reports']);
    Route::post('/reports',[ReportController::class, 'store'])->name('reports.store')->middleware(['auth', 'role:create-reports']);
    Route::delete('/reports/{id}',[ReportController::class, 'destroy'])->name('reports.destroy')->middleware(['auth', 'role:delete-reports']);
    Route::get('/reports/{id}/edit',[ReportController::class, 'edit'])->name('reports.edit')->middleware(['auth', 'role:delete-reports']);;
    Route::put('/reports/{id}',[ReportController::class, 'update'])->name('reports.update')->middleware(['auth', 'role:delete-reports']);;
    Route::post('/reports/search',[ReportController::class, 'searchForReports'])->name('reports.search')->middleware('auth');

Route::get('/users/{id}/show',[UserController::class, 'show'])->name('users.show')->middleware('auth');


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

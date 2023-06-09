<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return !auth()->user() 
            ? redirect( route("login") )
            : Inertia::render('ItemList/Index', [
               'canLogin' => Route::has('login'),
               'canRegister' => Route::has('register'),
               'laravelVersion' => Application::VERSION,
               'phpVersion' => PHP_VERSION,
            ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/list', function () {
        return Inertia::render('ItemList/Index');
    })->name('list.index');

    Route::resource( "/departments", \App\Http\Controllers\DepartmentController::class );
    Route::resource( "/items", \App\Http\Controllers\ItemController::class );
    Route::resource('/list', \App\Http\Controllers\ItemListController::class );
    Route::put('/list/{id}', 'ItemListController@update')->name('list.update');
});


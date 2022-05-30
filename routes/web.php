<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\TidingController::class, 'index'])->name('tidings.index');
Route::delete('/', [App\Http\Controllers\TidingController::class, 'deleteAll'])->name('tidings.deleteAll');

Route::post('scrap', [App\Http\Controllers\TidingScraperController::class, 'scrap'])->name('scrapers.scrap');
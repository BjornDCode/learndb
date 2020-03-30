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


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index');

Route::middleware(['auth'])->group(function() {
    Route::get('/library', 'SeriesController@index')->name('library');

    Route::get('/series/{series}/lesson/{lesson}', 'LessonController@show')->name('lesson.show');
});

Route::get('/series/{series}', 'SeriesController@show')->name('series.show');



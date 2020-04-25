<?php

use App\Lesson;
use App\Series;
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


Route::middleware(['auth'])->group(function() {
    Route::get('/', function () {
        return redirect(route('library'));
    })->name('home');
    
    Route::get('/library', 'SeriesController@index')->name('library');
    Route::get('/series/{series}', 'SeriesController@show')->name('series.show');

    Route::get('/series/{series}/lesson/{lesson}', 'LessonController@show')->name('lesson.show');
    Route::bind('lesson', function ($lesson, $route) {
        $series = Series::where('slug', $route->parameter('series'))->firstOrFail();
        return Lesson::where('series_id', $series->id)->where('slug', $lesson)->firstOrFail();
    });

    Route::post('/series/{series}/lesson/{lesson}/answers', 'AnswerController@store')->name('answers.store');
    Route::post('/comments', 'CommentController@store')->name('comment.store');
    Route::post('/activities', 'ActivityController@store')->name('activity.store');
});




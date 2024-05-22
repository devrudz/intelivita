<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\User\QuizeController as UserQuizeController;
use App\Http\Controllers\User\UserResultController;
use App\Http\Controllers\ViewUserResultController;


Route::get('/', function () {
    return view('welcome');
});


// Admin authentication routes
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::get('dashboard', [AdminController::class, 'index']);
    Route::post('login', [AdminController::class, 'login']);
    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');

    // Quiz Controller


    Route::resource('quizzes', QuizController::class);
    Route::resource('questions', QuestionController::class);
    Route::resource('answers', AnswerController::class);
    Route::get('quizzes/list', [QuizController::class, 'list'])->name('quizzes.list');

    Route::resource('viewresult', ViewUserResultController::class);
})->middleware('auth:admin');

Auth::routes();


Route::prefix('user')->group(function () {
    Route::resource('quizes', UserQuizeController::class);
    Route::resource('result', UserResultController::class);
})->middleware('auth:user');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('quiz_started', function(){
    \Session::put('quiz_status', 'started');
});

<?php

use Illuminate\Support\Facades\Route;

use App\Models\User;


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

RateLimiter::for('global', function (Request $request) {
    return $request->user()
                ? Limit::perMinute(100)->by($request->user()->id)
                : Limit::perMinute(10)->by($request->ip());
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', function () {
    return view('login');
})->name('login');

Route::get('register', function () {
    return view('register');
})->name('register');

Route::get('home', function () {
    return view('home');
})->name('home');


Route::get('/hello', function() {
    return 'Hello World';
})->middleware('auth');

 
Route::get('/user/{user:user_id}', function (User $user) {
    return $user;
});

Route::middleware(['auth', 'throttle:10,1'])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    Route::get('/user/{user:user_id}', function (User $user) {
        return $user;
    });

});
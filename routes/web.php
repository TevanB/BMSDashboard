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
Auth::routes(['verify'=>true]);

Route::get('/boosting', function () {
    return view('layouts.order');
});


Route::get('/', function () {
    return view('layouts.app');
});





Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

//Route::get('/boosting', 'OrderController@index')->name('home');

/*Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
*/
Route::get('/chat', 'ChatsController@index')->name('chat')->middleware('auth');


Route::get('messages/{id}', 'ChatsController@fetchMessages')->middleware('auth');

Route::post('messages', 'ChatsController@sendMessage')->middleware('auth');

//Route::get('messages/{id}', 'ChatsController@getMessage');

Route::get('{path}',"HomeController@index")->where('path','([A-z\d\-\/_.]+)?')->middleware('auth');

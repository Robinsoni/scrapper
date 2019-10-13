<?php

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

Route::get('/home', 'HomeController@index');// this will go into the HomeController
// and it will load the index method

Route::get('/', function () {
    return view('searchEngine');
});

Route::get('/contact-us', function () {
    return view('contact');
});
Route::get('/login', function () {
	$languages = ['java','php','sql'];
	
	
    return view('login.register',['lang'=>$languages]);
});
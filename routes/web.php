<?php
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group([
    'prefix' => '/settings'
],function(){
    Route::get('/','HomeController@settings');
    
    Route::patch('/','HomeController@updatePassword');
});

Route::post('/add','HomeController@store');

Route::patch('/update/{id}','HomeController@update');

Route::delete('/delete/{id}','HomeController@destroy');

Route::get('/show','HomeController@show');
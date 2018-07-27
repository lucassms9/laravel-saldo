<?php

$this->group(['middleware' => ['auth'] , 'namespace'=>'Admin', 'prefix' => 'admin' ], function(){

    Route::post('deposit', 'BalanceController@depositStore')->name('deposit.store');
    Route::get('deposit', 'BalanceController@deposit')->name('admin.deposit');
    Route::get('balance/', 'BalanceController@index')->name('admin.balance');
    Route::get('/', 'AdminController@index')->name('admin.home');
    
});

Route::get('/', 'Site\SiteController@index')->name('home');

Auth::routes();



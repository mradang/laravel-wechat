<?php

Route::group([
    'prefix' => 'api',
    'namespace' => 'mradang\LaravelWechat\Controllers',
], function () {
    Route::group(['prefix' => 'wechat'], function () {
        Route::post('login', 'WeChatController@login');
        Route::get('auth', 'WeChatController@auth');
        Route::post('config', 'WeChatController@config');
    });
});

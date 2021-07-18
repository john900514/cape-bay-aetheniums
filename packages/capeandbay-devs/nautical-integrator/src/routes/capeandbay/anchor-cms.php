<?php

Route::group(
    [
        'namespace'  => 'AnchorCMS\Nautical\Http\Controllers',
        'middleware' => 'web'
    ],
    function() {
        Route::get('/', 'JWTAuthController@homeRoute');
        //Route::get('auto-log/{uuid}', 'Auth\SSOLoginController@login');
    }
);

Route::group(
    [
        'namespace'  => 'AnchorCMS\Nautical\Http\Controllers',
        'middleware' => 'api'
    ],
    function() {
        Route::post('login', 'JWTAuthController@login');
        //Route::post('logout', 'JWTAuthController@logout');
        //Route::post('refresh', 'JWTAuthController@refresh');
        //Route::post('me', 'JWTAuthController@me');
    }
);

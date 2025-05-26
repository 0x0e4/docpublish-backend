<?php

use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::setDefaultNamespace('app\controllers');
SimpleRouter::group([
    'prefix' => '/api',
    'middleware' => [
        app\middlewares\ProcessRawBody::class
    ]
], function () {
    SimpleRouter::post('/auth','AuthController@login');
    SimpleRouter::group([
        'prefix'=> '/params',
    ], function () {
        SimpleRouter::get('/setprice/{price}','ParamController@setPrice');
        SimpleRouter::post('/create','ParamController@create');
        SimpleRouter::get('/get','ParamController@printParams');
        SimpleRouter::get('/delete','ParamController@delete');
    });
    SimpleRouter::group([
        'prefix'=> '/docs',
    ], function () {
        SimpleRouter::post('/create','DocumentController@create');
    });
    SimpleRouter::all('/{url}', 'DocumentController@default');
});
<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('/firm', FirmController::class);

    $router->any('/reglist', 'FirmController@reglist');//注册展示
    $router->any('/audit', 'FirmController@audit');//审核执行
});

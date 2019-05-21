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

Route::get('/', function () {
    return view('welcome');
});
//注册
 Route::get('/firm/reg','Firm\FirmController@reg')->middleware('auth');
 Route::post('/firm/rega','Firm\FirmController@rega');

 Route::get('/firm/token','Firm\FirmController@token'); //生成token

Route::middleware('token','num')->group(function(){
 Route::get('/firm/client','Firm\FirmController@client'); //客户端ip
 Route::get('/firm/clientu','Firm\FirmController@clientu'); //客户端ua
 Route::get('/firm/listreg','Firm\FirmController@listreg'); //显示用户信息

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

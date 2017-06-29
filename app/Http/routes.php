<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//前台登录
Route::get('/', function () {
    return view('home.login.login');
});
//登录页面
Route::get('/admin',function(){
	redirect('/admin/login/login');
});
//验证码
Route::get('/code','CodeController@code');
//登录操作
Route::controller('/admin/login','Admin\LoginController');
//后台主页
Route::controller('/admin/index','Admin\IndexController');
//后台用户
Route::controller('/admin/user','Admin\UserController');


//前台注册
Route::controller('/home/zhuce','Home\ZhuceController');
//前台登陆
Route::controller('/home/login','Home\LoginController');


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
//    $file_name="abc.mp3";
//    $info=pathinfo($file_name);
//
//    echo $file_name.'的文件扩展名为:'.pathinfo($file_name)['extension'];die;

    return view('welcome');
});

Route::get('/test/','Test\TestController@admin');
Route::get('test/xml','Test\TestController@xmlTest');
Route::get('/test/redis1','Test\TestController@redis1');
Route::get('/test/redis2','Test\TestController@redis2');


//微信开发
Route::get('/Wx/test','WeiXin\WxController@test');
Route::get('/Wx/','WeiXin\WxController@index');
Route::post('/Wx/','WeiXin\WxController@receiv');
Route::get('/Wx/media','WeiXin\WxController@getMedia');//获取临时素材

Route::get('/Wx/menu','WeiXin\WxController@createMenu');//创建微信自定义菜单

//微信公众号
Route::get('/vote','VoteController@index');        //微信投票




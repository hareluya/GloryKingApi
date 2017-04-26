<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['namespace' => 'Api'], function () {

    //英雄相关接口
    Route::group(['prefix' => 'hero'], function () {
        Route::get('/', 'HeroController@postHeroList'); //英雄列表
        Route::get('type-list', 'HeroController@postHeroTypeList'); //英雄类型列表
    });

    //素材相关接口
    Route::group(['prefix' => 'element'], function () {
        Route::get('/', 'ElementController@postElementList'); //素材列表
    });
});

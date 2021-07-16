<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('auth')->group(function(){
    Route::post('/login', 'API\AuthController@login');
    Route::group(['middleware' => ['attemp.auth']], function(){
        Route::get('/profile', 'API\AuthController@profile');
        Route::get('/logout', 'API\AuthController@logout');
    });
});

Route::group(['middleware' => ['attemp.auth']], function(){
    Route::prefix('merchant')->group(function(){
        Route::get('/', 'API\MerchantController@index')->middleware('roles.permissions');
        Route::get('/{id}', 'API\MerchantController@show');
        Route::post('/', 'API\MerchantController@store')->middleware('roles.permissions');
        Route::put('/{id}', 'API\MerchantController@update');
        Route::delete('/{id}', 'API\MerchantController@destroy')->middleware('roles.permissions');;
    });

    Route::group(['prefix' => 'user', 'middleware' => ['roles.permissions']], function(){
        Route::get('/', 'API\UserController@index');
        Route::get('/{id}', 'API\UserController@show');
        Route::post('/', 'API\UserController@store');
        Route::put('/{id}', 'API\UserController@update');
        Route::delete('/{id}', 'API\UserController@destroy');
        Route::post('/assign-admin', 'API\UserController@assign_admin');
    });

    Route::prefix('product')->group(function(){
        Route::get('/', 'API\ProductController@index');
        Route::get('/{id}', 'API\ProductController@show');
        Route::post('/', 'API\ProductController@store');
        Route::put('/{id}', 'API\ProductController@update');
        Route::delete('/{id}', 'API\ProductController@destroy');
    });

    Route::prefix('category')->group(function(){
        Route::get('/', 'API\CategoryController@index');
        Route::get('/{id}', 'API\CategoryController@show');
        Route::post('/', 'API\CategoryController@store');
        Route::put('/{id}', 'API\CategoryController@update');
        Route::delete('/{id}', 'API\CategoryController@destroy');
    });
});


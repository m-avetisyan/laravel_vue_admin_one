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
Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/confirmation/{token}', 'AuthController@confirm');
    Route::post('/generate', 'AuthController@generate');
});
Route::group(['middleware' => ['auth.jwt']], function () {

    /* Categories Routes*/
    Route::get('/category', 'CategoryController@index');
    Route::get('/category/{id}', 'CategoryController@show');
    Route::post('/category/new/', 'CategoryController@store');
    Route::put('/category/{id}', 'CategoryController@update');
    Route::delete('/category/{id}', 'CategoryController@destroy');
    Route::get('/categories', 'CategoryController@all');
    /* END*/


    /* Posts Routes*/
    Route::get('/post', 'PostController@index');
    Route::get('/post/{id}', 'PostController@show');
    Route::post('/post/new/', 'PostController@store');
    Route::put('/post/{id}', 'PostController@update');
    Route::delete('/post/{id}', 'PostController@destroy');
    /*END */

    /*Cart Items Routes*/
    Route::post('/cartItem/new/{id}', 'CartItemController@store');
    Route::get('/cartItems/', 'CartItemController@index');
    Route::delete('/cartItem/{id}', 'CartItemController@destroy');
    /* END*/

    Route::post('/order/new', 'BillingController@addOrder');
    Route::get('/orders/', 'BillingController@getOrders');
    Route::post('/subscription/new/', 'BillingController@addSubscription');
    Route::get('/subscriptions/', 'BillingController@getSubscriptions');

    Route::get('/card', 'CardController@index');
    Route::get('/card/{id}', 'CardController@show');
    Route::post('/card/new/', 'CardController@store');
    Route::put('/card/{id}', 'CardController@update');
    Route::delete('/card/{id}', 'CardController@destroy');

    Route::get('/users', 'UserController@index');
    Route::get('/users/{id}', 'UserController@show');
    Route::put('/users/{id}', 'UserController@update');
    Route::put('/users/{id}/status', 'UserController@updateStatus');



});

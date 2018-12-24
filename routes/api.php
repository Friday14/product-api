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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('login', 'SessionController@login');
    Route::post('logout', 'SessionController@logout');
    Route::post('refresh', 'SessionController@refresh');
    Route::post('me', 'SessionController@me');
});

Route::resource('categories', 'CategoriesController')->except(['create', 'edit']);
Route::resource('products', 'ProductsController')->except(['index', 'create', 'edit']);

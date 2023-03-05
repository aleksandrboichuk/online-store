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
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function (){
    Route::get('/product/getCategoriesOrSubcategoriesData', [\App\Http\Controllers\Api\Admin\AjaxController::class, 'getCategoriesOrSubcategoriesData'])
        ->name('api.admin.getCategoriesOrSubcategoriesData');
});

Route::group(['prefix' => 'public'], function (){
    Route::post('/cart/add', [\App\Http\Controllers\Api\Public\AjaxController::class, 'addToCart'])
        ->name('api.public.cart.add');

    Route::post('/cart/update', [\App\Http\Controllers\Api\Public\AjaxController::class, 'updateCart'])
        ->name('api.public.cart.update');
});

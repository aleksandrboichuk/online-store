<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
Route::get('/cart/{user_id}', [\App\Http\Controllers\CartController::class, 'showUserCart'])->name('show.cart');

if(preg_match("#^\/women#", \request()->getRequestUri()) == false && preg_match("#^\/men#", \request()->getRequestUri()) == false){
    Route::get('/{code}/',function($code){
        if($code === 'login'){
            $app = app();
            $controller = $app->make(\App\Http\Controllers\Auth\LoginController::class);
            return $controller->showLoginForm();
        }else if ($code === 'register'){
            $app = app();
            $controller = $app->make(\App\Http\Controllers\Auth\RegisterController::class);
            return $controller->showRegistrationForm();
        }
    })->middleware('app.auth');
}

Route::post('/{product_id}/{user_id}',[\App\Http\Controllers\CartController::class, 'addToCart'])->name('add.to.cart')->middleware('auth');
Route::get('/search',[\App\Http\Controllers\SearchController::class, 'index']);

Route::get('/','\App\Http\Controllers\CategoryGroupController@home');

Route::get('/{group_seo_name}', [\App\Http\Controllers\CategoryGroupController::class,'index'])->name('index');

Route::get('/{group_seo_name}/{category_seo_name}',[\App\Http\Controllers\CategoryController::class,'index'])->name('show.category');

Route::get('/{group_seo_name}/{category_seo_name}/{sub_category_seo_name}',[\App\Http\Controllers\CategoryController::class,'showSubCategoryProducts'])->name('show.sub.category');

Route::get('/{group_seo_name}/{category_seo_name}/{sub_category_seo_name}/{product_seo_name}',[\App\Http\Controllers\ProductController::class, 'showProductDetails'])->name('show.product.details');



Auth::routes();


Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'toLogin'])->name('login');
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'toRegister'])->name('register');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

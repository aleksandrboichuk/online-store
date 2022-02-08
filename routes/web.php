<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/search',[\App\Http\Controllers\SearchController::class, 'index']);

Route::get('/','\App\Http\Controllers\HomeController@home');

Route::get('/{group_seo_name}',[\App\Http\Controllers\HomeController::class,'index'])->name('index');

Route::get('/{group_seo_name}/{category_seo_name}',[\App\Http\Controllers\CategoryController::class,'index'])->name('show.category');

Route::get('/{group_seo_name}/{category_seo_name}/{sub_category_seo_name}',[\App\Http\Controllers\CategoryController::class,'showSubCategoryProducts'])->name('show.sub.category');

Route::get('/{group_seo_name}/{category_seo_name}/{sub_category_seo_name}/{product_seo_name}',[\App\Http\Controllers\ProductController::class, 'showProductDetails'])->name('show.product.details');

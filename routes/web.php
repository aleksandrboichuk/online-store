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
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

if(preg_match("#^\/women#", \request()->getRequestUri()) == false
    && preg_match("#^\/men#", \request()->getRequestUri()) == false
    && preg_match("#^\/girls#", \request()->getRequestUri()) == false
    && preg_match("#^\/boys#", \request()->getRequestUri()) == false){

    Route::get('/{code}/',function($code){
        if($code === 'login'){
            $app = app();
            $controller = $app->make(\App\Http\Controllers\Auth\LoginController::class);
            return $controller->showLoginForm();
        }else if ($code === 'register'){
            $app = app();
            $controller = $app->make(\App\Http\Controllers\Auth\RegisterController::class);
            return $controller->showRegistrationForm();
        }else if ($code === 'admin') {
            $app = app();
            $controller = $app->make(\App\Http\Controllers\AdminController::class);
            return $controller->index();
        }
    })->middleware('app.auth');
}

Route::group([
    'prefix' => 'admin', // префикс маршрута, например user/index
    'middleware' => ['auth'] // один или несколько посредников
],function () {
    // categories
    Route::get('/categories', [\App\Http\Controllers\AdminController::class, 'categoryIndex']);
    Route::get('/categories/add', [\App\Http\Controllers\AdminController::class, 'addCategory']);
    Route::get('/categories/edit/{category_id}', [\App\Http\Controllers\AdminController::class, 'editCategory'])->name('edit.category');

    Route::post('/categories/add',[\App\Http\Controllers\AdminController::class, 'saveAddCategory'])->name('save.category');
    Route::post('/categories/save-edit', [\App\Http\Controllers\AdminController::class, 'saveEditCategory'])->name('save.edit.category');
    Route::post('/categories/delete/{category_id}',[\App\Http\Controllers\AdminController::class, 'delCategory'])->name('delete.category');

    //products

    Route::get('/products', [\App\Http\Controllers\AdminController::class, 'productIndex']);
    Route::get('/products/add', [\App\Http\Controllers\AdminController::class, 'addProduct']);
    Route::get('/products/edit/{product_id}', [\App\Http\Controllers\AdminController::class, 'editProduct'])->name('edit.product');

    Route::post('/products/add',[\App\Http\Controllers\AdminController::class, 'saveAddProduct'])->name('save.product');
    Route::post('/products/save-edit', [\App\Http\Controllers\AdminController::class, 'saveEditProduct'])->name('save.edit.product');
    Route::post('/products/delete/{product_id}',[\App\Http\Controllers\AdminController::class, 'delProduct'])->name('delete.product');

    // orders
    Route::get('/orders', [\App\Http\Controllers\AdminController::class, 'orderIndex']);
    Route::get('/orders/edit/{order_id}', [\App\Http\Controllers\AdminController::class, 'editOrder'])->name('edit.order');
    Route::post('/orders/save-edit', [\App\Http\Controllers\AdminController::class, 'saveEditOrder'])->name('save.edit.order');
    Route::post('/orders/delete/{order_id}',[\App\Http\Controllers\AdminController::class, 'delOrder'])->name('delete.order');

});
//cart
Route::group([
    'prefix' => 'cart',
    'middleware' => ['auth']
], function () {
    Route::get('/{user_id}', [\App\Http\Controllers\CartController::class, 'showUserCart'])->name('show.cart');
    Route::get('/checkout/{user_id}', [\App\Http\Controllers\CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/delete-from-cart',[\App\Http\Controllers\CartController::class, 'deleteFromCart'])->name('delete.from.cart');

    Route::post('/save-order', [\App\Http\Controllers\CheckoutController::class, 'saveOrder'])->name('save.order');
});

Route::group([
    'prefix' => 'personal',
    'middleware' => ['auth']
],function () {

    Route::get('/orders',[\App\Http\Controllers\UserController::class, 'getUserOrders'])->name('user.orders');
    Route::get('/orders/view-order/{order_id}', [\App\Http\Controllers\UserController::class, 'viewUserOrder'])->name('view.order');
});

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




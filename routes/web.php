<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function (){
    return redirect('/shop/women');
});

/**
 * Contact page
 */
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::post('/send-message',  [App\Http\Controllers\HomeController::class, 'sendMessage'])->name('send.message');


/**
 * admin
 */
Route::group([
    'prefix' => 'admin',
    'middleware' => ['app.auth', 'auth']
],function () {
    Route::get('', [\App\Http\Controllers\Admin\AdminController::class, 'index']);
    Route::resource('promocodes', \App\Http\Controllers\Admin\PromocodeController::class)->middleware('content.manager.role');
    Route::get('/banners/{cat_group?}', [\App\Http\Controllers\Admin\BannerController::class, 'index'])->middleware('content.manager.role');
    Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class)->middleware('content.manager.role');
    Route::resource('messages', \App\Http\Controllers\Admin\MessageController::class)->middleware('orders.admin.role');
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->middleware('content.manager.role');
    Route::resource('subcategories', \App\Http\Controllers\Admin\SubCategoryController::class)->middleware('content.manager.role');
    Route::get('/products/{cat_group?}', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->middleware('content.manager.role');
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)->middleware('content.manager.role');
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->middleware('orders.admin.role');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->middleware('main.admin.role');
    Route::resource('colors', \App\Http\Controllers\Admin\ColorController::class)->middleware('content.manager.role');
    Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class)->middleware('content.manager.role');
    Route::resource('materials', \App\Http\Controllers\Admin\MaterialController::class)->middleware('content.manager.role');
    Route::resource('sizes', \App\Http\Controllers\Admin\SizeController::class)->middleware('content.manager.role');
});


/**
 * Cart
 */
Route::group([
    'prefix' => 'cart',
], function () {
    Route::get('', [\App\Http\Controllers\CartController::class, 'index'])->name('cart');
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
    Route::post('/delete-from-cart',[\App\Http\Controllers\CartController::class, 'deleteFromCart'])->name('delete.from.cart');
    Route::post('/save-order', [\App\Http\Controllers\CheckoutController::class, 'saveOrder'])->name('save.order');
});


/**
 * personal
 */
Route::group([
    'prefix' => 'personal',
    'middleware' => ['auth']
],function () {

    Route::get('/',function () {
        return redirect('/personal/orders');
    });

    Route::get('/orders/{status?}',[\App\Http\Controllers\Profile\ProfileController::class, 'index'])
        ->name('user.orders');

    Route::get('/orders/view-order/{order_id}', [\App\Http\Controllers\Profile\OrderController::class, 'index'])
        ->name('view.order');

    Route::get('/promocodes', [\App\Http\Controllers\Profile\PromocodeController::class, 'index'])
        ->name('user.promocodes');

    Route::get('/settings', [\App\Http\Controllers\Profile\SettingsController::class, 'index'])
        ->name('user.settings');

    Route::post('/settings-save', [\App\Http\Controllers\Profile\SettingsController::class, 'saveUserSettings'])
        ->name('user.settings.save');

});


/**
 * promotions
 */
Route::group([
    'prefix' => 'promotions',
],function () {
    if(preg_match("/\?colors|\?brands|\?materials|\?orderBy|\?seasons|\?sizes|\?price/", request()->getRequestUri())) {

        Route::any('/{group_seo_name?}/{banner_seo_name?}', [\App\Http\Controllers\SearchFilterController::class, 'index'])
            ->name('filters.request');

    }
    Route::get('/{group_seo_name}/{seo_name_banner}', [\App\Http\Controllers\PromotionController::class, 'index'])
        ->name('promotion');
});


/**
 * shop
 */
Route::group([
    'prefix' => 'shop',
    'middleware' => ['cart.by.token']
], function () {

Route::get('/{group_seo_name}/search',[\App\Http\Controllers\SearchController::class, 'index'])->name('search');
Route::post('/{product_id}/{user_id}',[\App\Http\Controllers\CartController::class, 'addToCart'])->name('add.to.cart')
    ->middleware('auth');
Route::get('/','\App\Http\Controllers\CategoryGroupController@home');

if(preg_match("/\?colors|\?brands|\?materials|\?orderBy|\?seasons|\?sizes|\?price/", request()->getRequestUri())){

    Route::any('/{seo_name?}/{category_seo_name?}/{sub_category_seo_name?}', [\App\Http\Controllers\SearchFilterController::class, 'index'])
        ->name('filters.request');
}

Route::get('/{group_seo_name}', [\App\Http\Controllers\CategoryGroupController::class,'index'])
    ->name('index');
Route::get('/{group_seo_name}/{category_seo_name}',[\App\Http\Controllers\CategoryController::class,'index'])
    ->name('category');
Route::get('/{group_seo_name}/{category_seo_name}/{sub_category_seo_name}',[\App\Http\Controllers\SubCategoryController::class,'index'])
    ->name('subcategory');
Route::get('/{group_seo_name}/{category_seo_name}/{sub_category_seo_name}/{product_seo_name}',[\App\Http\Controllers\ProductController::class, 'index'])    ->name('product');

//send product review
Route::post('/{product_id}',[\App\Http\Controllers\ReviewController::class, 'index'])->name('send.review');
});


/**
 * auth
 */
Auth::routes();

Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']);
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'toLogin'])->name('login');

Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm']);
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'toRegister'])->name('register');

Route::get('/logout', function(){ Auth::logout(); return redirect()->back(); });

//   Reset password by email
Route::get('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showForgotPasswordForm']);

Route::post('/send-code', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendEmailWithCode'])->name('send.code');

Route::get('/password/reset/{token}', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'showPasswordResetForm'])
    ->name('password.reset');

Route::post('/password-reset', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'toResetPassword'])
    ->name('reset.password');



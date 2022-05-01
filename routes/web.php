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

Route::get('/', function (){
    return redirect('/shop/women');
});


Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::post('/send-message',  [App\Http\Controllers\HomeController::class, 'sendMessage'])->name('send.message');

if(preg_match("#^\/login#", \request()->getRequestUri()) == true
    || preg_match("#^\/register#", \request()->getRequestUri()) == true
    || preg_match("#^\/admin#", \request()->getRequestUri()) == true
    || preg_match("#^\/forgot-password#", \request()->getRequestUri()) == true
){

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
        else if ($code === 'forgot-password') {
            $app = app();
            $controller = $app->make(\App\Http\Controllers\Auth\ForgotPasswordController::class);
            return $controller->showForgotPasswordForm();
        }
    })->middleware('app.auth');
}

/**
 * 404
 */

if(preg_match("#^\/register\b#", \request()->getRequestUri()) == false
    && preg_match("#^\/logout\b#", \request()->getRequestUri()) == false
    && preg_match("#^\/login\b#", \request()->getRequestUri()) == false
    && preg_match("#^\/forgot-password\b#", \request()->getRequestUri()) == false
    && preg_match("#^\/search\b#", \request()->getRequestUri()) == false
    && preg_match("#^\/admin\b#", \request()->getRequestUri()) == false
    && preg_match("#^\/personal\b#", \request()->getRequestUri()) == false
    && preg_match("#^\/promotions\b#", \request()->getRequestUri()) == false
    && preg_match("#^\/cart\b#", \request()->getRequestUri()) == false
    && preg_match("#^\/shop\b#", \request()->getRequestUri()) == false) {
    Route::get('{any?}', function () {
        if(!Auth::user()){
            $cart = \App\Models\Cart::where('token', session()->getId())->first();
        }
        return response()->view('errors.404', ['user' => Auth::user(), 'cart' => isset($cart) ? $cart : null ], 404);
    })->where('any', '.*');
}


/**
 * admin
 */

Route::group([
    'prefix' => 'admin',
    'middleware' => ['app.auth', 'auth']
],function () {

    Route::resource('promocodes', \App\Http\Controllers\Admin\PromocodeController::class);
    if(!preg_match("#^\/admin/banners/create\b#", \request()->getRequestUri())) {
        Route::get('/banners/{cat_group?}', [\App\Http\Controllers\Admin\BannerController::class, 'index']);
    }
        Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class);
    Route::resource('messages', \App\Http\Controllers\Admin\MessageController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('subcategories', \App\Http\Controllers\Admin\SubCategoryController::class);
    if(!preg_match("#^\/admin/products/create\b#", \request()->getRequestUri())) {
        Route::get('/products/{cat_group?}', [\App\Http\Controllers\Admin\ProductController::class, 'index']);
    }
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('colors', \App\Http\Controllers\Admin\ColorController::class);
    Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class);
    Route::resource('materials', \App\Http\Controllers\Admin\MaterialController::class);
    Route::resource('sizes', \App\Http\Controllers\Admin\SizeController::class);

});


/**
 * cart
 */

Route::group([
    'prefix' => 'cart',
], function () {

    Route::get('', [\App\Http\Controllers\CartController::class, 'showUserCart'])->name('show.cart');
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'checkout'])->name('checkout');
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

    if(preg_match("#^\/personal/orders\b#", \request()->getRequestUri()) == false
        && preg_match("#^\/personal/settings\b#", \request()->getRequestUri()) == false
        && preg_match("#^\/personal/promocodes\b#", \request()->getRequestUri()) == false
        //&& preg_match("#^\/personal/bonuses\b#", \request()->getRequestUri()) == false
    ) {
        Route::get('/{any?}', function () {
            return response()->view('errors.404', ['user' => Auth::user()], 404);
        })->where('any', '.*');
    }

    Route::get('/orders/{status?}',[\App\Http\Controllers\UserController::class, 'getUserOrders'])->name('user.orders');
    Route::get('/orders/view-order/{order_id}', [\App\Http\Controllers\UserController::class, 'viewUserOrder'])->name('view.order');
    Route::get('/promocodes', [\App\Http\Controllers\UserController::class, 'getUserPromocodes'])->name('user.promocodes');
    //Route::get('/bonuses', [\App\Http\Controllers\UserController::class, 'gerUserBonuses'])->name('user.bonuses');

    Route::get('/settings', [\App\Http\Controllers\UserController::class, 'getUserSettings'])->name('user.settings');
    Route::post('/settings-save', [\App\Http\Controllers\UserController::class, 'saveUserSettings'])->name('user.settings.save');

});

/**
 * promotions
 */

Route::group([
    'prefix' => 'promotions',
],function () {
    if(preg_match("/\?colors/", request()->getRequestUri())
        || preg_match("/\?brands/", request()->getRequestUri())
        || preg_match("/\?materials/", request()->getRequestUri())
        || preg_match("/\?orderBy/", request()->getRequestUri())
        || preg_match("/\?seasons/", request()->getRequestUri())
        || preg_match("/\?sizes/", request()->getRequestUri())
        || preg_match("/\?price/", request()->getRequestUri())){
        Route::any('/{group_seo_name?}/{banner_seo_name?}/{queryString?}', [\App\Http\Controllers\SearchController::class, 'filtersRequest'])->name('filters.request');
    }
    Route::get('/{group_seo_name}/{seo_name_banner}',[\App\Http\Controllers\PromotionController::class, 'index'])->name('show.promotion.details');
});

/**
 * shop
 */

Route::group([
    'prefix' => 'shop',
    'middleware' => ['cart.by.token']
], function () {

Route::get('/{group_seo_name}/search',[\App\Http\Controllers\SearchController::class, 'index'])->name('search');
Route::post('/{product_id}/{user_id}',[\App\Http\Controllers\CartController::class, 'addToCart'])->name('add.to.cart')->middleware('auth');
Route::get('/','\App\Http\Controllers\CategoryGroupController@home');

if(preg_match("/\?colors/", request()->getRequestUri())
    || preg_match("/\?brands/", request()->getRequestUri())
    || preg_match("/\?materials/", request()->getRequestUri())
    || preg_match("/\?orderBy/", request()->getRequestUri())
    || preg_match("/\?seasons/", request()->getRequestUri())
    || preg_match("/\?sizes/", request()->getRequestUri())
    || preg_match("/\?price/", request()->getRequestUri())){
    Route::any('/{seo_name?}/{category_seo_name?}/{sub_category_seo_name?}/{queryString?}', [\App\Http\Controllers\SearchController::class, 'filtersRequest'])->name('filters.request');
}

Route::get('/{group_seo_name}', [\App\Http\Controllers\CategoryGroupController::class,'index'])->name('index');
Route::get('/{group_seo_name}/{category_seo_name}',[\App\Http\Controllers\CategoryController::class,'index'])->name('show.category');
Route::get('/{group_seo_name}/{category_seo_name}/{sub_category_seo_name}',[\App\Http\Controllers\SubCategoryController::class,'index'])->name('show.sub.category');
Route::get('/{group_seo_name}/{category_seo_name}/{sub_category_seo_name}/{product_seo_name}',[\App\Http\Controllers\ProductController::class, 'showProductDetails'])->name('show.product.details');

//send product review
Route::post('/{product_id}',[\App\Http\Controllers\ProductController::class, 'sendReview'])->name('send.review');

});


/**
 * auth
 */

Auth::routes();

Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'toLogin'])->name('login');
Route::get('/logout', function(){
    Auth::logout();
    return redirect()->back();
});
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'toRegister'])->name('register');

// ========================== Reset password by email =====================================================
Route::post('/send-code', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendEmailWithCode'])->name('send.code');
Route::post('/confirm-code', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'confirmEmailCode'])->name('confirm.code');
Route::post('/save-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'savePassword'])->name('save.password');




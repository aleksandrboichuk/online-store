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

//redirect to category group page
//TODO:: add page, where user can chose category group (men, women etc.)
Route::get('/', function (){
    return redirect('/shop/women');
});

/**
 * Contact page
 */
//  contact page
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
//  process feedback request
Route::post('/send-message',  [App\Http\Controllers\HomeController::class, 'sendMessage'])->name('send.message');


/**
 * admin
 */
Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth']
],function () {
    //admin panel CRUD operations
    Route::get('', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.panel');
    Route::resource('promocodes', \App\Http\Controllers\Admin\PromocodeController::class);
    Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class)->except('show');
    Route::get('/banners/{cat_group?}', [\App\Http\Controllers\Admin\BannerController::class, 'index']);
    Route::resource('messages', \App\Http\Controllers\Admin\MessageController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('category-groups', \App\Http\Controllers\Admin\CategoryGroupController::class);
    Route::resource('subcategories', \App\Http\Controllers\Admin\SubCategoryController::class);
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)->except('show');
    Route::get('/products/{cat_group?}', [\App\Http\Controllers\Admin\ProductController::class, 'index']);
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('colors', \App\Http\Controllers\Admin\ColorController::class);
    Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class);
    Route::resource('materials', \App\Http\Controllers\Admin\MaterialController::class);
    Route::resource('sizes', \App\Http\Controllers\Admin\SizeController::class);
});


/**
 * Cart
 */
Route::group([
    'prefix' => 'cart',
], function () {
    //  cart page
    Route::get('', [\App\Http\Controllers\CartController::class, 'index'])->name('cart');
    //  checkout page
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
    //  delete from cart request
    Route::post('/delete-from-cart',[\App\Http\Controllers\CartController::class, 'deleteFromCart'])->name('delete.from.cart');
    //  process and save order
    Route::post('/save-order', [\App\Http\Controllers\CheckoutController::class, 'saveOrder'])->name('save.order');
});


/**
 * user profile
 */
Route::group([
    'prefix' => 'personal',
    'middleware' => ['auth']
],function () {
    // redirect to user orders page
    Route::get('/',function () {
        return redirect('/personal/orders');
    });
    // user orders page
    Route::get('/orders/{status?}',[\App\Http\Controllers\Profile\ProfileController::class, 'index'])
        ->name('user.orders');
    // view selected order
    Route::get('/orders/view-order/{order_id}', [\App\Http\Controllers\Profile\OrderController::class, 'index'])
        ->name('view.order');
    // view promodoces
    Route::get('/promocodes', [\App\Http\Controllers\Profile\PromocodeController::class, 'index'])
        ->name('user.promocodes');
    // edit settings
    Route::get('/settings', [\App\Http\Controllers\Profile\SettingsController::class, 'index'])
        ->name('user.settings');
    //save new settings
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
        // accepting filters at promotion shop page
        Route::any('/{group_seo_name?}/{banner_seo_name?}', [\App\Http\Controllers\SearchFilterController::class, 'index'])
            ->name('filters.request');
    }

//  promotion page
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
//  search products
Route::get('/{group_seo_name}/search',[\App\Http\Controllers\SearchController::class, 'index'])->name('search');
// ajax post add product to cart
Route::post('/{product_id}/{user_id}',[\App\Http\Controllers\CartController::class, 'addToCart'])
    ->name('add.to.cart')
    ->middleware('auth');

// accepting filters at any shop page
if(preg_match("/\?colors|\?brands|\?materials|\?orderBy|\?seasons|\?sizes|\?price/", request()->getRequestUri())){

    Route::any('/{seo_name?}/{category_seo_name?}/{sub_category_seo_name?}', [\App\Http\Controllers\SearchFilterController::class, 'index'])
        ->name('filters.request');
}

//  category group page
Route::get('/{group_seo_name}', [\App\Http\Controllers\CategoryGroupController::class,'index'])
    ->name('index');
//  category page
Route::get('/{group_seo_name}/{category_seo_name}',[\App\Http\Controllers\CategoryController::class,'index'])
    ->name('category');
//  subcategory page
Route::get('/{group_seo_name}/{category_seo_name}/{sub_category_seo_name}',[\App\Http\Controllers\SubCategoryController::class,'index'])
    ->name('subcategory');
//  product page
Route::get('/{group_seo_name}/{category_seo_name}/{sub_category_seo_name}/{product_seo_name}',[\App\Http\Controllers\ProductController::class, 'index'])    ->name('product');

// send product review request
Route::post('/{product_id}',[\App\Http\Controllers\ReviewController::class, 'index'])->name('send.review');

});


/**
 * auth
 */
Auth::routes();
//  login
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']);
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'toLogin'])->name('login');
//  register
Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm']);
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');
//  logout
Route::get('/logout', function(){ Auth::logout(); return redirect()->back(); });
//  Reset password by email
Route::get('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showForgotPasswordForm']);
Route::post('/send-code', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendEmailWithCode'])->name('send.code');
Route::get('/password/reset/{token}', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'showPasswordResetForm'])->name('password.reset');
Route::post('/password-reset', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'toResetPassword'])->name('reset.password');



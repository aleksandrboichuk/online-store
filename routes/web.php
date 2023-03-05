<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\SeasonController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryGroupController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Profile\OrderController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Profile\PromocodeController;
use App\Http\Controllers\Profile\SettingsController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SearchFilterController;
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
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
//  process feedback request
Route::post('/send-message',  [App\Http\Controllers\ContactController::class, 'sendMessage'])->name('send.message');


/**
 * admin
 */
Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth']
],function () {
    //admin panel CRUD operations
    Route::get('', [AdminController::class, 'index'])->name('admin.panel');
    Route::resource('promocodes', \App\Http\Controllers\Admin\PromocodeController::class);
    Route::resource('banners', BannerController::class)->except('show');
    Route::get('/banners/{cat_group?}', [BannerController::class, 'index']);
    Route::resource('messages', MessageController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('category-groups', \App\Http\Controllers\Admin\CategoryGroupController::class);
//    Route::resource('subcategories', \App\Http\Controllers\Admin\SubCategoryController::class);
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)->except('show');
    Route::get('/products/{cat_group?}', [\App\Http\Controllers\Admin\ProductController::class, 'index']);
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
    Route::resource('users', UserController::class);
    Route::resource('colors', ColorController::class);
    Route::resource('seasons', SeasonController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('materials', MaterialController::class);
    Route::resource('sizes', SizeController::class);
});


/**
 * Cart
 */
Route::group([
    'prefix' => 'cart',
], function () {
    //  cart page
    Route::get('', [CartController::class, 'index'])->name('cart');
    //  checkout page
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    //  delete from cart request
    Route::post('/delete-from-cart',[CartController::class, 'deleteFromCart'])->name('delete.from.cart');
    //  process and save order
    Route::post('/save-order', [CheckoutController::class, 'saveOrder'])->name('save.order');
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
    Route::get('/orders/{status?}',[ProfileController::class, 'index'])
        ->name('user.orders');
    // view selected order
    Route::get('/orders/view-order/{order_id}', [OrderController::class, 'index'])
        ->name('view.order');
    // view promodoces
    Route::get('/promocodes', [PromocodeController::class, 'index'])
        ->name('user.promocodes');
    // edit settings
    Route::get('/settings', [SettingsController::class, 'index'])
        ->name('user.settings');
    //save new settings
    Route::post('/settings-save', [SettingsController::class, 'saveUserSettings'])
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
        Route::any('/{group_seo_name?}/{banner_seo_name?}', [SearchFilterController::class, 'index'])
            ->name('filters.request');
    }

//  promotion page
    Route::get('/{group_seo_name}/{seo_name_banner}', [PromotionController::class, 'index'])
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
Route::get('/{group_seo_name}/search',[SearchController::class, 'index'])->name('search');
// ajax post add product to cart
Route::post('/{product_id}/{user_id}',[CartController::class, 'addToCart'])
    ->name('add.to.cart')
    ->middleware('auth');

// accepting filters at any shop page
if(preg_match("/\?colors|\?brands|\?materials|\?orderBy|\?seasons|\?sizes|\?price/", request()->getRequestUri())){

    Route::any('/{group_seo_name?}/{category_seo_name?}/{sub_category_seo_name?}', [SearchFilterController::class, 'index'])
        ->name('filters.request');
}

//  category group page
Route::get('/{group_seo_name}', [CategoryGroupController::class,'index'])
    ->name('index');
//  product page
Route::get('/{category_seo_name}/{product_seo_name}.php',[ProductController::class, 'index'])
    ->name('product');
//  category page
Route::get('/{group_seo_name}/{category_seo_name}/{second_category_seo_name?}', [CategoryController::class,'index'])
    ->name('category');
// send product review request
Route::post('/{product_id}',[ReviewController::class, 'index'])->name('send.review');

});


/**
 * auth
 */
Auth::routes();
//  login
Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'toLogin'])->name('login');
//  register
Route::get('/register', [RegisterController::class, 'showRegistrationForm']);
Route::post('/register', [RegisterController::class, 'register'])->name('register');
//  logout
Route::get('/logout', function(){ Auth::logout(); return redirect()->back(); });
//  Reset password by email
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm']);
Route::post('/send-code', [ForgotPasswordController::class, 'sendEmailWithCode'])->name('send.code');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showPasswordResetForm'])->name('password.reset');
Route::post('/password-reset', [ResetPasswordController::class, 'toResetPassword'])->name('reset.password');



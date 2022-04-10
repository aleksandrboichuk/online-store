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
    //|| preg_match("#^\/forgot-password#", \request()->getRequestUri()) == true
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
//        else if ($code === 'forgot-password') {
//            $app = app();
//            $controller = $app->make(\App\Http\Controllers\Auth\ForgotPasswordController::class);
//            return $controller->showForgotPasswordForm();
//        }
    })->middleware('app.auth');
}

/**
 * 404
 */

if(preg_match("#^\/register\b#", \request()->getRequestUri()) == false
    && preg_match("#^\/logout\b#", \request()->getRequestUri()) == false
    && preg_match("#^\/login\b#", \request()->getRequestUri()) == false
    //&& preg_match("#^\/forgot-password\b#", \request()->getRequestUri()) == false
    && preg_match("#^\/search\b#", \request()->getRequestUri()) == false
    && preg_match("#^\/admin\b#", \request()->getRequestUri()) == false
    && preg_match("#^\/personal\b#", \request()->getRequestUri()) == false
    && preg_match("#^\/promotions\b#", \request()->getRequestUri()) == false
    && preg_match("#^\/cart\b#", \request()->getRequestUri()) == false
    && preg_match("#^\/shop\b#", \request()->getRequestUri()) == false) {
    Route::get('{any?}', function () {
        if(!Auth::user()){
            $cart = \App\Models\Cart::where('token', session('_token'))->first();
        }
        return response()->view('errors.404', ['user' => Auth::user(), 'cart' => isset($cart) ? $cart : null ], 404);
    })->where('any', '.*');
}


/**
 * admin
 */

Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => ['app.auth', 'auth']
],function () {

    //banner
    if(preg_match("#^\/admin/banner/add\b#", \request()->getRequestUri()) == false) {
        Route::get('/banner/{cat_group?}', [\App\Http\Controllers\Admin\BannerController::class, 'index']);
    }
    Route::get('/banner/add', [\App\Http\Controllers\Admin\BannerController::class, 'addBanner']);
    Route::get('/banner/edit/{banner_id}', [\App\Http\Controllers\Admin\BannerController::class, 'editBanner'])->name('edit.banner');

    Route::post('/banner/add',[\App\Http\Controllers\Admin\BannerController::class, 'saveAddBanner'])->name('save.banner');
    Route::post('/banner/save-edit', [\App\Http\Controllers\Admin\BannerController::class, 'saveEditBanner'])->name('save.edit.banner');
    Route::post('/banner/delete/{banner_id}',[\App\Http\Controllers\Admin\BannerController::class, 'delBanner'])->name('delete.banner');

    //messages

    Route::get('/messages', [\App\Http\Controllers\Admin\MessageController::class, 'index']);
    Route::get('/messages/{message_id}', [\App\Http\Controllers\Admin\MessageController::class, 'showMessage'])->name('show.message');

    Route::post('/messages/delete/{message_id}',[\App\Http\Controllers\Admin\MessageController::class, 'delMessage'])->name('delete.message');


    // categories

    Route::get('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index']);
    Route::get('/categories/add', [\App\Http\Controllers\Admin\CategoryController::class, 'addCategory']);
    Route::get('/categories/edit/{category_id}', [\App\Http\Controllers\Admin\CategoryController::class, 'editCategory'])->name('edit.category');

    Route::post('/categories/add',[\App\Http\Controllers\Admin\CategoryController::class, 'saveAddCategory'])->name('save.category');
    Route::post('/categories/save-edit', [\App\Http\Controllers\Admin\CategoryController::class, 'saveEditCategory'])->name('save.edit.category');
    Route::post('/categories/delete/{category_id}',[\App\Http\Controllers\Admin\CategoryController::class, 'delCategory'])->name('delete.category');

    // sub categories

    Route::get('/subcategories', [\App\Http\Controllers\Admin\SubCategoryController::class, 'index']);
    Route::get('/subcategories/add', [\App\Http\Controllers\Admin\SubCategoryController::class, 'addSubCategory']);
    Route::get('/subcategories/edit/{subcategory_id}', [\App\Http\Controllers\Admin\SubCategoryController::class, 'editSubCategory'])->name('edit.subcategory');

    Route::post('/subcategories/add',[\App\Http\Controllers\Admin\SubCategoryController::class, 'saveAddSubCategory'])->name('save.subcategory');
    Route::post('/subcategories/save-edit', [\App\Http\Controllers\Admin\SubCategoryController::class, 'saveEditSubCategory'])->name('save.edit.subcategory');
    Route::post('/subcategories/delete/{subcategory_id}',[\App\Http\Controllers\Admin\SubCategoryController::class, 'delSubCategory'])->name('delete.subcategory');

    //products

    if(preg_match("#^\/admin/products/add\b#", \request()->getRequestUri()) == false) {
        Route::get('/products/{cat_group?}', [\App\Http\Controllers\Admin\ProductController::class, 'index']);
    }
    Route::get('/products/add', [\App\Http\Controllers\Admin\ProductController::class, 'addProduct'])->name('add.product');
    Route::get('/products/edit/{product_id}', [\App\Http\Controllers\Admin\ProductController::class, 'editProduct'])->name('edit.product');

    Route::post('/products/add',[\App\Http\Controllers\Admin\ProductController::class, 'saveAddProduct'])->name('save.product');
    Route::post('/products/save-edit', [\App\Http\Controllers\Admin\ProductController::class, 'saveEditProduct'])->name('save.edit.product');
    Route::post('/products/delete/{product_id}',[\App\Http\Controllers\Admin\ProductController::class, 'delProduct'])->name('delete.product');

    // orders
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index']);
    Route::get('/orders/edit/{order_id}', [\App\Http\Controllers\Admin\OrderController::class, 'editOrder'])->name('edit.order');
    Route::post('/orders/save-edit', [\App\Http\Controllers\Admin\OrderController::class, 'saveEditOrder'])->name('save.edit.order');
    Route::post('/orders/delete/{order_id}',[\App\Http\Controllers\Admin\OrderController::class, 'delOrder'])->name('delete.order');

    //users

    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index']);
    Route::get('/users/edit/{user_id}', [\App\Http\Controllers\Admin\UserController::class, 'editUser'])->name('edit.user');
    Route::post('/users/save-edit', [\App\Http\Controllers\Admin\UserController::class, 'saveEditUser'])->name('save.edit.user');
    Route::post('/users/delete/{user_id}',[\App\Http\Controllers\Admin\UserController::class, 'delUser'])->name('delete.user');

    //colors

    Route::get('/colors', [\App\Http\Controllers\Admin\ColorController::class, 'index']);
    Route::get('/colors/add', [\App\Http\Controllers\Admin\ColorController::class, 'addColor']);
    Route::get('/colors/edit/{color_id}', [\App\Http\Controllers\Admin\ColorController::class, 'editColor'])->name('edit.color');

    Route::post('/colors/add',[\App\Http\Controllers\Admin\ColorController::class, 'saveAddColor'])->name('save.color');
    Route::post('/colors/save-edit', [\App\Http\Controllers\Admin\ColorController::class, 'saveEditColor'])->name('save.edit.color');
    Route::post('/colors/delete/{color_id}',[\App\Http\Controllers\Admin\ColorController::class, 'delColor'])->name('delete.color');

    //brands

    Route::get('/brands', [\App\Http\Controllers\Admin\BrandController::class, 'index']);
    Route::get('/brands/add', [\App\Http\Controllers\Admin\BrandController::class, 'addBrand']);
    Route::get('/brands/edit/{brand_id}', [\App\Http\Controllers\Admin\BrandController::class, 'editBrand'])->name('edit.brand');

    Route::post('/brands/add',[\App\Http\Controllers\Admin\BrandController::class, 'saveAddBrand'])->name('save.brand');
    Route::post('/brands/save-edit', [\App\Http\Controllers\Admin\BrandController::class, 'saveEditBrand'])->name('save.edit.brand');
    Route::post('/brands/delete/{brand_id}',[\App\Http\Controllers\Admin\BrandController::class, 'delBrand'])->name('delete.brand');

    //materials

    Route::get('/materials', [\App\Http\Controllers\Admin\MaterialController::class, 'index']);
    Route::get('/materials/add', [\App\Http\Controllers\Admin\MaterialController::class, 'addMaterial']);
    Route::get('/materials/edit/{material_id}', [\App\Http\Controllers\Admin\MaterialController::class, 'editMaterial'])->name('edit.material');

    Route::post('/materials/add',[\App\Http\Controllers\Admin\MaterialController::class, 'saveAddMaterial'])->name('save.material');
    Route::post('/materials/save-edit', [\App\Http\Controllers\Admin\MaterialController::class, 'saveEditMaterial'])->name('save.edit.material');
    Route::post('/materials/delete/{material_id}',[\App\Http\Controllers\Admin\MaterialController::class, 'delMaterial'])->name('delete.material');

    //sizes

    Route::get('/sizes', [\App\Http\Controllers\Admin\SizeController::class, 'index']);
    Route::get('/sizes/add', [\App\Http\Controllers\Admin\SizeController::class, 'addSize']);
    Route::get('/sizes/edit/{size_id}', [\App\Http\Controllers\Admin\SizeController::class, 'editSize'])->name('edit.size');

    Route::post('/sizes/add',[\App\Http\Controllers\Admin\SizeController::class, 'saveAddSize'])->name('save.size');
    Route::post('/sizes/save-edit', [\App\Http\Controllers\Admin\SizeController::class, 'saveEditSize'])->name('save.edit.size');
    Route::post('/sizes/delete/{size_id}',[\App\Http\Controllers\Admin\SizeController::class, 'delSize'])->name('delete.size');

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

// Mail::to($request->user())->send(new OrderShipped($order));

Auth::routes();

Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'toLogin'])->name('login');
Route::get('/logout', function(){
    Auth::logout();
    return redirect()->back();
});
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'toRegister'])->name('register');




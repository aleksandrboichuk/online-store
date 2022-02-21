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
    || preg_match("#^\/admin#", \request()->getRequestUri()) == true){

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

/**
 * 404
 */

if(preg_match("#^\/register#", \request()->getRequestUri()) == false
    && preg_match("#^\/logout#", \request()->getRequestUri()) == false
    && preg_match("#^\/login#", \request()->getRequestUri()) == false
    && preg_match("#^\/search#", \request()->getRequestUri()) == false
    && preg_match("#^\/admin#", \request()->getRequestUri()) == false
    && preg_match("#^\/personal#", \request()->getRequestUri()) == false) {

    Route::get('/{code}/',[\App\Http\Controllers\HomeController::class, 'throwError']);

}

Route::group([
    'prefix' => 'admin',
    'middleware' => ['app.auth', 'auth']
],function () {

    //banner

    Route::get('/banner', [\App\Http\Controllers\AdminController::class, 'bannerIndex']);
    Route::get('/banner/add', [\App\Http\Controllers\AdminController::class, 'addBanner']);
    Route::get('/banner/edit/{banner_id}', [\App\Http\Controllers\AdminController::class, 'editBanner'])->name('edit.banner');

    Route::post('/banner/add',[\App\Http\Controllers\AdminController::class, 'saveAddBanner'])->name('save.banner');
    Route::post('/banner/save-edit', [\App\Http\Controllers\AdminController::class, 'saveEditBanner'])->name('save.edit.banner');
    Route::post('/banner/delete/{banner_id}',[\App\Http\Controllers\AdminController::class, 'delBanner'])->name('delete.banner');

    // categories
    Route::get('/categories', [\App\Http\Controllers\AdminController::class, 'categoryIndex']);
    Route::get('/categories/add', [\App\Http\Controllers\AdminController::class, 'addCategory']);
    Route::get('/categories/edit/{category_id}', [\App\Http\Controllers\AdminController::class, 'editCategory'])->name('edit.category');

    Route::post('/categories/add',[\App\Http\Controllers\AdminController::class, 'saveAddCategory'])->name('save.category');
    Route::post('/categories/save-edit', [\App\Http\Controllers\AdminController::class, 'saveEditCategory'])->name('save.edit.category');
    Route::post('/categories/delete/{category_id}',[\App\Http\Controllers\AdminController::class, 'delCategory'])->name('delete.category');

    // sub categories
    Route::get('/subcategories', [\App\Http\Controllers\AdminController::class, 'subcategoryIndex']);
    Route::get('/subcategories/add', [\App\Http\Controllers\AdminController::class, 'addSubCategory']);
    Route::get('/subcategories/edit/{subcategory_id}', [\App\Http\Controllers\AdminController::class, 'editSubCategory'])->name('edit.subcategory');

    Route::post('/subcategories/add',[\App\Http\Controllers\AdminController::class, 'saveAddSubCategory'])->name('save.subcategory');
    Route::post('/subcategories/save-edit', [\App\Http\Controllers\AdminController::class, 'saveEditSubCategory'])->name('save.edit.subcategory');
    Route::post('/subcategories/delete/{subcategory_id}',[\App\Http\Controllers\AdminController::class, 'delSubCategory'])->name('delete.subcategory');

    //products

    Route::get('/products', [\App\Http\Controllers\AdminController::class, 'productIndex']);
    Route::get('/products/men', [\App\Http\Controllers\AdminController::class, 'productIndexMen']);
    Route::get('/products/women', [\App\Http\Controllers\AdminController::class, 'productIndexWomen']);
    Route::get('/products/boys', [\App\Http\Controllers\AdminController::class, 'productIndexBoys']);
    Route::get('/products/girls', [\App\Http\Controllers\AdminController::class, 'productIndexGirls']);

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

    //users

    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'userIndex']);
    Route::get('/users/edit/{user_id}', [\App\Http\Controllers\AdminController::class, 'editUser'])->name('edit.user');
    Route::post('/users/save-edit', [\App\Http\Controllers\AdminController::class, 'saveEditUser'])->name('save.edit.user');
    Route::post('/users/delete/{user_id}',[\App\Http\Controllers\AdminController::class, 'delUser'])->name('delete.user');

    //colors

    Route::get('/colors', [\App\Http\Controllers\AdminController::class, 'colorIndex']);
    Route::get('/colors/add', [\App\Http\Controllers\AdminController::class, 'addColor']);
    Route::get('/colors/edit/{color_id}', [\App\Http\Controllers\AdminController::class, 'editColor'])->name('edit.color');

    Route::post('/colors/add',[\App\Http\Controllers\AdminController::class, 'saveAddColor'])->name('save.color');
    Route::post('/colors/save-edit', [\App\Http\Controllers\AdminController::class, 'saveEditColor'])->name('save.edit.color');
    Route::post('/colors/delete/{color_id}',[\App\Http\Controllers\AdminController::class, 'delColor'])->name('delete.color');

    //brands

    Route::get('/brands', [\App\Http\Controllers\AdminController::class, 'brandIndex']);
    Route::get('/brands/add', [\App\Http\Controllers\AdminController::class, 'addBrand']);
    Route::get('/brands/edit/{brand_id}', [\App\Http\Controllers\AdminController::class, 'editBrand'])->name('edit.brand');

    Route::post('/brands/add',[\App\Http\Controllers\AdminController::class, 'saveAddBrand'])->name('save.brand');
    Route::post('/brands/save-edit', [\App\Http\Controllers\AdminController::class, 'saveEditBrand'])->name('save.edit.brand');
    Route::post('/brands/delete/{brand_id}',[\App\Http\Controllers\AdminController::class, 'delBrand'])->name('delete.brand');


    //materials

    Route::get('/materials', [\App\Http\Controllers\AdminController::class, 'materialIndex']);
    Route::get('/materials/add', [\App\Http\Controllers\AdminController::class, 'addMaterial']);
    Route::get('/materials/edit/{material_id}', [\App\Http\Controllers\AdminController::class, 'editMaterial'])->name('edit.material');

    Route::post('/materials/add',[\App\Http\Controllers\AdminController::class, 'saveAddMaterial'])->name('save.material');
    Route::post('/materials/save-edit', [\App\Http\Controllers\AdminController::class, 'saveEditMaterial'])->name('save.edit.material');
    Route::post('/materials/delete/{material_id}',[\App\Http\Controllers\AdminController::class, 'delMaterial'])->name('delete.material');

    //sizes

    Route::get('/sizes', [\App\Http\Controllers\AdminController::class, 'sizeIndex']);
    Route::get('/sizes/add', [\App\Http\Controllers\AdminController::class, 'addSize']);
    Route::get('/sizes/edit/{size_id}', [\App\Http\Controllers\AdminController::class, 'editSize'])->name('edit.size');

    Route::post('/sizes/add',[\App\Http\Controllers\AdminController::class, 'saveAddSize'])->name('save.size');
    Route::post('/sizes/save-edit', [\App\Http\Controllers\AdminController::class, 'saveEditSize'])->name('save.edit.size');
    Route::post('/sizes/delete/{size_id}',[\App\Http\Controllers\AdminController::class, 'delSize'])->name('delete.size');

});


/**
 * cart
 */

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

/**
 * shop
 */

Route::group([
    'prefix' => 'shop',
], function () {


Route::get('/{seo_names}/search',[\App\Http\Controllers\SearchController::class, 'index'])->name('search');

Route::post('/{product_id}/{user_id}',[\App\Http\Controllers\CartController::class, 'addToCart'])->name('add.to.cart')->middleware('auth');

Route::get('/','\App\Http\Controllers\CategoryGroupController@home');
Route::get('/{group_seo_name}', [\App\Http\Controllers\CategoryGroupController::class,'index'])->name('index');
Route::get('/{group_seo_name}/{category_seo_name}',[\App\Http\Controllers\CategoryController::class,'index'])->name('show.category');
Route::get('/{group_seo_name}/{category_seo_name}/{sub_category_seo_name}',[\App\Http\Controllers\CategoryController::class,'showSubCategoryProducts'])->name('show.sub.category');
Route::get('/{group_seo_name}/{category_seo_name}/{sub_category_seo_name}/{product_seo_name}',[\App\Http\Controllers\ProductController::class, 'showProductDetails'])->name('show.product.details');

});


/**
 * auth
 */


Auth::routes();

Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'toLogin'])->name('login');
Route::get('/logout', function(){
    Auth::logout();
    return redirect('/login');
});
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'toRegister'])->name('register');




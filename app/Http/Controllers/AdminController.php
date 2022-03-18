<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\OrdersList;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductMaterial;
use App\Models\ProductSeason;
use App\Models\ProductSize;
use App\Models\StatusList;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserMessage;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Util\Color;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'user'=>$this->getUser(),
        ]);
    }


    /*
     *
     * Editing/Adding/Saving CATEGORIES
     *
    */




    public function bannerIndex($cat_group = null)
    {
        $banners = Banner::orderBy('id', 'desc')->get();
        if (!empty($cat_group)) {
            switch ($cat_group) {
                case 'men':
                    $banners = Banner::where('category_group_id', 1)->orderBy('id', 'desc')->get();
                    break;
                case 'women':
                    $banners = Banner::where('category_group_id', 2)->orderBy('id', 'desc')->get();
                    break;
                case 'boys':
                    $banners = Banner::where('category_group_id', 3)->orderBy('id', 'desc')->get();
                    break;
                case 'girls':
                    $banners = Banner::where('category_group_id', 4)->orderBy('id', 'desc')->get();
                    break;
            }
        }
        return view('admin.banner.index',[
            'user'=>$this->getUser(),
            'banners' => $banners,

        ]);
    }

    //show adding form

    public function addBanner(){

        return view('admin.banner.add',[
            'user'=>$this->getUser(),
            'category_groups' => CategoryGroup::where('active', 1)->get(),
        ]);
    }

    //saving add

    public function saveAddBanner(Request $request){
        $banner = new Banner;
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $banner->create([
            'title' => $request['title-field'],
            'category_group_id' => $request['cat-field'],
            'seo_name' => $request['seo-field'],
            'description' => $request['description-field'],
            'image_url' => $request['main-img-field'],
            'mini_img_url' => $request['mini-img-field'],
            'active' => $active,
        ]);

        session(['success-message' => 'Банер успішно додано.']);
        return redirect('/admin/banner');
    }

    //editing

    public function editBanner($banner_id){
        $banner = Banner::find($banner_id);

        if(!$banner){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }
        return view('admin.banner.edit',[
            'user' => $this->getUser(),
            'banner' => $banner ,
            'category_groups' => CategoryGroup::all()

        ]);
    }


    //saving edit

    public function saveEditBanner(Request $request){

        $banner = Banner::find($request['id']);
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $banner->update([
            'title' => $request['title-field'],
            'category_group_id' => $request['cat-field'],
            'seo_name' => $request['seo-field'],
            'description' => $request['description-field'],
            'image_url' => $request['main-img-field'],
            'mini_img_url' => $request['mini-img-field'],
            'active' => $active,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        session(['success-message' => 'Банер успішно змінено.']);
        return redirect("/admin/banner");
    }

    //delete

    public function delBanner($banner_id){
        $banner = Banner::find($banner_id);
        $banner->delete();
        session(['success-message' => 'Банер успішно видалено.']);
        return redirect("/admin/banner");
    }



    /*
            *
            * Editing/Adding/Saving MESSAGES
            *
           */



    public function messagesIndex()
    {
        $messages = UserMessage::orderBy('id', 'desc')->paginate(3);

        if(request()->ajax()){
            return view('admin.message.ajax.ajax-pagination', [
                'messages' => $messages,
            ])->render();
        }

        return view('admin.message.index',[
            'user'=>$this->getUser(),
            'messages' => $messages,

        ]);
    }

    //showing

    public function showMessage($message_id){
        $message = UserMessage::find($message_id);

        if(!$message){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }
        return view('admin.message.single-message',[
            'user' => $this->getUser(),
            'message' => $message ,

        ]);
    }

    //delete

    public function delMessage($message_id){
        $message = UserMessage::find($message_id);
        $message->delete();
        session(['success-message' => 'Повідомлення успішно видалено.']);
        return redirect("/admin/messages");
    }


            /*
             *
             * Editing/Adding/Saving CATEGORIES
             *
            */




    public function categoryIndex()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin.category.index',[
            'user'=>$this->getUser(),
            'categories' => $categories
        ]);
    }

    //show adding form

    public function addCategory(){

        return view('admin.category.add',[
            'user'=>$this->getUser(),
            'category_groups' => CategoryGroup::where('active', 1)->get()
        ]);
    }

    //saving add

    public function saveAddCategory(Request $request){
        Validator::make($request->all(), [
            'title-field' => ['required', 'string', 'max:255', 'unique:categories'],
            'name-field' => ['required', 'string', 'max:255', 'unique:categories'],
            'seo-field' => ['required', 'string', 'min:8',  'unique:categories']
        ]);

        $category = new Category;
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $category->create([
            'title' => $request['title-field'],
            'name' => $request['name-field'],
            'seo_name' => $request['seo-field'],
            'active' => $active,
        ]);
        $addedCategory = Category::where('title', $request['title-field'])->first();
        $category->categoryGroups()->attach($addedCategory->id,[
            'category_group_id' => $request['cat-field'],
            'category_id' => $addedCategory->id
        ]);
        session(['success-message' => 'Категорію успішно додано.']);
        return redirect('/admin/categories');
    }

    //editing

    public function editCategory($category_id){
        $category =  Category::find($category_id);

        if(!$category){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }
        return view('admin.category.edit',[
            'user' => $this->getUser(),
            'category' => $category,
            'category_groups' => CategoryGroup::all()

        ]);
    }


    //saving edit

    public function saveEditCategory(Request $request){

        $category = Category::find($request['id']);
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        // отключаем все продукты категории и подкатегории,
        // если саму категорию отключили
        if($category->active == 1 && $active == false){
            foreach ($category->products as $product) {
                $product->update(['active' => $active]);
            }
            foreach ($category->subCategories as $subCat) {
                $subCat->update(['active' => $active]);
            }
        }elseif($category->active == 0 && $active == true){
            foreach ($category->products as $product) {
                $product->update(['active' => $active]);
            }
            foreach ($category->subCategories as $subCat) {
                $subCat->update(['active' => $active]);
            }
        }

        $category->update([
            'title' => $request['title-field'],
            'name' => $request['name-field'],
            'seo_name' => $request['seo-field'],
            'active' => $active,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        $category->categoryGroups()->where('category_id', $request['id'])->update(["category_group_id" => $request['cat-field']]);
        session(['success-message' => 'Категорію успішно змінено.']);
        return redirect("/admin/categories");
    }

    //delete

    public function delCategory($category_id){
        $category = Category::find($category_id);
        $category->delete();
        session(['success-message' => 'Категорію успішно видалено.']);
        return redirect("/admin/categories");
    }

            /*
                 *
                 * Editing/Adding/Saving SUB-CATEGORIES
                 *
                */

    public function subcategoryIndex()
    {
        $subcategories =  SubCategory::orderBy('id', 'desc')->get();
        return view('admin.subcategory.index',[
            'user'=>$this->getUser(),
            'subcategories' => $subcategories
        ]);
    }

    //show adding form

    public function addSubCategory(){

        return view('admin.subcategory.add',[
            'user'=>$this->getUser(),
            'categories' => Category::where('active', 1)->get()
        ]);
    }

    //saving add

    public function saveAddSubCategory(Request $request){
        Validator::make($request->all(), [
            'title-field' => ['required', 'string', 'max:255', 'unique:sub_categories'],
            'name-field' => ['required', 'string', 'max:255', 'unique:sub_categories'],
            'seo-field' => ['required', 'string', 'min:8',  'unique:sub_categories']
        ]);

        $subcategory = new SubCategory;
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $subcategory->create([
            'title' => $request['title-field'],
            'name' => $request['name-field'],
            'seo_name' => $request['seo-field'],
            'category_id' => $request['cat-field'],
            'active' => $active,
        ]);
        session(['success-message' => 'Підкатегорію успішно додано.']);
        return redirect('/admin/subcategories');
    }

    //editing

    public function editSubCategory($subcategory_id){
        $subCategory = SubCategory::find($subcategory_id);

        if(!$subCategory){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }
        return view('admin.subcategory.edit',[
            'user' => $this->getUser(),
            'subcategory' =>  $subCategory,
            'categories' => Category::all()
        ]);
    }


    //saving edit

    public function saveEditSubCategory(Request $request){

        $subcategory = SubCategory::find($request['id']);
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }

        // отключаем все продукты подкатегории,
        // если саму подкатегории отключили

        if($subcategory->active == 1 && $active == false){
            foreach ($subcategory->products as $product) {
                $product->update(['active' => $active]);
            }
        }elseif($subcategory->active == 0 && $active == true){
            foreach ($subcategory->products as $product) {
                $product->update(['active' => $active]);
            }
        }

        $subcategory->update([
            'title' => $request['title-field'],
            'name' => $request['name-field'],
            'seo_name' => $request['seo-field'],
            'category_id' =>  $request['cat-field'],
            'active' => $active,
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        session(['success-message' => 'Підкатегорію успішно змінено.']);
        return redirect("/admin/subcategories");
    }

    //delete

    public function delSubCategory($subcategory_id){
        $subcategory = SubCategory::find($subcategory_id);
        $subcategory->delete();
        session(['success-message' => 'Підкатегорію успішно видалено.']);
        return redirect("/admin/subcategories");
    }

            /*
             *
             * Editing/Adding/Saving PRODUCTS
             *
            */


    public function productIndex(Request $request,$cat_group = null){
        $products = Product::orderBy('id', 'desc')->paginate(5);
        if (!empty($cat_group)) {
            switch ($cat_group) {
                case 'men':
                    $products = Product::where('category_group_id', 1)->orderBy('id', 'desc')->paginate(5);
                    if($request->ajax()){
                        return view('admin.product.ajax.ajax-pagination',[
                            'products' => $products,
                        ])->render();
                    }
                    break;
                case 'women':
                    $products = Product::where('category_group_id', 2)->orderBy('id', 'desc')->paginate(5);
                    if($request->ajax()){
                        return view('admin.product.ajax.ajax-pagination',[
                            'products' => $products,
                        ])->render();
                    }
                    break;
                case 'boys':
                    $products = Product::where('category_group_id', 3)->orderBy('id', 'desc')->paginate(5);
                    if($request->ajax()){
                        return view('admin.product.ajax.ajax-pagination',[
                            'products' => $products,
                        ])->render();
                    }
                    break;
                case 'girls':
                    $products = Product::where('category_group_id', 4)->orderBy('id', 'desc')->paginate(5);
                    if($request->ajax()){
                        return view('admin.product.ajax.ajax-pagination',[
                            'products' => $products,
                        ])->render();
                    }
                    break;
            }
        }

        if($request->ajax()){
            return view('admin.product.ajax.ajax-pagination',[
                'products' => $products,
            ])->render();
        }

        return view('admin.product.index', [
            'user' => $this->getUser(),
            'products' => $products
        ]);
    }


    //show adding form

    public function addProduct(Request $request){

// --------------------------------------- AJAX -----------------------------------------------
        if(isset($request['categoryGroup']) && !empty($request['categoryGroup'])){
           $categoryGroup = CategoryGroup::find($request['categoryGroup']);
            if(request()->ajax()){
                return view('admin.product.ajax.ajax-category', [
                    'user'=>$this->getUser(),
                    'categories' => $categoryGroup->categories,
                ])->render();
            }
        }elseif(isset($request['category']) && !empty($request['category'])){
            $category = Category::find($request['category']);
            if(request()->ajax()){
                return view('admin.product.ajax.ajax-subcategory', [
                    'user'=>$this->getUser(),
                    'sub_categories' => $category->subCategories,
                ])->render();
            }
        }

        return view('admin.product.add',[
            'user'=>$this->getUser(),
            'category_groups' => CategoryGroup::where('active', 1)->get(),
            'categories' => Category::where('active', 1)->get(),
            'sub_categories' => SubCategory::where('active', 1)->get(),
            'banners' => Banner::where('active', 1)->get(),
            'colors' => ProductColor::where('active', 1)->get(),
            'seasons' => ProductSeason::where('active', 1)->get(),
            'brands' => ProductBrand::where('active', 1)->get(),
            'materials' => ProductMaterial::where('active', 1)->get(),
            'sizes' => ProductSize::where('active', 1)->get(),
        ]);
    }

    //save adding

    public function saveAddProduct(Request $request){
        Validator::make($request->all(), [
            'name-field' => ['required', 'string', 'max:255', 'unique:products'],
            'seo-field' => ['required', 'string', 'min:3',  'unique:products'],
            'image-field'=>['required', 'string', 'min:5',  'unique:products'],
            'description-field'=>['required', 'string'],
            'price-field'=>['required', 'integer'],
            'discount-field'=>['required', 'integer'],
            'count-field'=>['required', 'integer'],
        ]);

        $product = new Product;
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $product->create([
            'name' => $request['name-field'],
            'seo_name' => $request['seo-field'],
            'preview_img_url' => $request->file('main-image-field')->getClientOriginalName(),
            'description' => $request['description-field'],
            'price' => $request['price-field'],
            'discount' => isset($request['discount-field']) ? intval($request['discount-field']) : 0 ,
            'banner_id' => isset($request['banner-field']) ? $request['banner-field'] : null ,
            'active' => $active,
            'category_group_id' => $request['cat-field'],
            'category_id' => $request['category-field'],
            'category_sub_id' => $request['sub-category-field'],
            'product_color_id' => $request['color-field'],
            'product_season_id' => $request['season-field'],
            'product_brand_id' => $request['brand-field'],
        ]);

        $getProduct = Product::where('name', $request['name-field'])->first();

        // добавление картинок в хранилище и в БД

        $mainImageFile = $request->file('main-image-field');
        $imageNames = [];
        //в первьюхи
        Storage::disk('public')->putFileAs('product-images/'.$getProduct->id.'/preview', $mainImageFile, $mainImageFile->getClientOriginalName());
        // в детальные изобр. заинуть превьюху
        Storage::disk('public')->putFileAs('product-images/'.$getProduct->id.'/details', $mainImageFile, $mainImageFile->getClientOriginalName());
        $imageNames['images'][0] = $mainImageFile->getClientOriginalName();

        // детальные изобр. все
        if(isset($request['additional-image-field-1'])){
            for($i = 1; $i <= 7; $i++){
                if(isset($request['additional-image-field-' . $i])){
                    $imgFile = $request->file('additional-image-field-' . $i);
                    Storage::disk('public')->putFileAs('product-images/'.$getProduct->id.'/details', $imgFile, $imgFile->getClientOriginalName());
                    $imageNames['images'][$i] = $imgFile->getClientOriginalName();
                }
            }
            foreach($imageNames['images'] as $addImage){
                ProductImage::create([
                    'url' => $addImage,
                    'product_id' => $getProduct->id
                ]);
            }
        }

        // материалы , размеры

        foreach ($request['materials'] as $key => $value){
            $getProduct->materials()->attach($getProduct->id,[
                'product_id' => $getProduct->id,
                'product_material_id' => $value
            ]);
        }

        if (isset($request['sizes'])) {
            foreach ($request['size-count'] as $k => $val) {
                if ($val != null) {
                    $sizeCount[] = $val;
                }
            }
            for($i = 0; $i < count($request['sizes']); $i++){
                $getProduct->sizes()->attach($getProduct->id,[
                    'product_id' => $getProduct->id,
                    'product_size_id' => $request['sizes'][$i],
                    'count' =>  isset($sizeCount[$i]) ? $sizeCount[$i] : 1
                ]);
            }
        }
        if(isset($getProduct->sizes) && !empty($getProduct->sizes)){
            $count = 0;
            foreach ($getProduct->sizes as $s){
                $count += $s->pivot->count;
            }
            $getProduct->update([
                'count' => $count
            ]);
        }

        session(['success-message' => 'Товар успішно додано.']);
        return redirect('/admin/products');
    }

    public function editProduct(Request $request,$product_id){
        $product = Product::find($product_id);

        if(!$product){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }
        // ajax на удаление картинки
            if(!empty($request->imgUrl)){
                ProductImage::where('url',($request->imgUrl))->delete();
                Storage::disk('public')->delete('product-images/'.$product->id.'/details/' . $request->imgUrl);
            }

        for($i = 0; $i < count($product->materials); $i++){
            $selectedMaterials[] =  $product->materials[$i]['id'];
        }

        for($i = 0; $i < count($product->sizes); $i++){
            $selectedSizes[] =  $product->sizes[$i]['id'];
        }

        // count of products every of size
        $product_sizes = $product->sizes()->where('product_id', $product->id)->get();
        foreach ($product_sizes as $key => $value) {
              $count_sizes[$value->id] = $value->pivot->count;
        }
       $banners = Banner::where('category_group_id', $product->categoryGroups->id)->get();

        return view('admin.product.edit',[
            'user' => $this->getUser(),
            'category_groups' => CategoryGroup::all(),
            'categories' => Category::all(),
            'sub_categories' => SubCategory::all(),
            'colors' => ProductColor::all(),
            'seasons' => ProductSeason::all(),
            'brands' => ProductBrand::all(),
            'materials' => ProductMaterial::all(),
            'sizes' => ProductSize::all(),
            'banners' => !empty($banners) ? $banners : null,
            'count_sizes' => isset($count_sizes) ? $count_sizes : null,
            'product' =>  $product,
            'selectedMaterials' => isset($selectedMaterials) ?  $selectedMaterials : [],
            'selectedSizes'=> isset($selectedSizes) ?  $selectedSizes : [],

        ]);
    }

    // save editing

    public function saveEditProduct(Request $request){
        $product = Product::find($request['id']);
        $active = false;

        if($request['active-field'] == "on"){
            $active = true;
        }

        // работа с картинками товара
        if(isset($request['main-image-field'])){
            $mainImageFile = $request->file('main-image-field');
            Storage::disk('public')->delete('product-images/'.$product->id.'/preview/' . $product->preview_img_url);
            Storage::disk('public')->putFileAs('product-images/'.$product->id.'/preview', $mainImageFile, $mainImageFile->getClientOriginalName());
            $product->update([
                'preview_img_url' => $mainImageFile->getClientOriginalName()
            ]);
        }

            $imageNames = [];
            $productImages = ProductImage::where('product_id', $product->id)->where('url', '!=', $product->preview_img_url)->get();

        // пройтись по полям из запроса, у которых
        // номер совпадает с уже сущ. номером картинки (чтобы если что ее заменить)
        //
            foreach ( $productImages as $key => $img) {
                if(isset($request['additional-image-field-' . ($key + 1)])){
                    $imgFile = $request->file('additional-image-field-' . ($key + 1));
                    Storage::disk('public')->delete('product-images/'.$product->id.'/details/' . $img->url);
                    Storage::disk('public')->putFileAs('product-images/'.$product->id.'/details', $imgFile, $imgFile->getClientOriginalName());
                    $img->update([
                       'url' => $imgFile->getClientOriginalName()
                    ]);
                }
            }

        // дфльше пройтись по остальным полям
        // у которых номера не совпадают с сущ. картинками у товара

            for($i = count($product->images); $i <= 7; $i++){
                if(isset($request['additional-image-field-' . $i])){
                    $imgFile = $request->file('additional-image-field-' . $i);
                    Storage::disk('public')->putFileAs('product-images/'.$product->id.'/details', $imgFile, $imgFile->getClientOriginalName());
                    $imageNames['images'][$i] = $imgFile->getClientOriginalName();
                }
            }
            if(!empty($imageNames)){
                foreach($imageNames['images'] as $addImage){
                    ProductImage::create([
                        'url' => $addImage,
                        'product_id' => $product->id
                    ]);
                }
            }

        $product->update([
            'name' => $request['name-field'],
            'seo_name' => $request['seo-field'],
            'description' => $request['description-field'],
            'price' => $request['price-field'],
            'discount' => isset($request['discount-field']) ? intval($request['discount-field']) : 0 ,
            'banner_id' => isset($request['banner-field']) ? $request['banner-field'] : null ,
            //'count' => $request['count-field'],
            'active' => $active,
            'category_group_id' => $request['cat-field'],
            'category_id' => $request['category-field'],
            'category_sub_id' => $request['sub-category-field'],
            'product_color_id' => $request['color-field'],
            'product_season_id' => $request['season-field'],
            'product_brand_id' => $request['brand-field'],
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        if (isset($request['materials'])) {
            $product->materials()->detach();
            foreach ($request['materials'] as $m) {
                $material = ProductMaterial::find($m);
                $product->materials()->save($material);
            }
        }else{
            $product->materials()->detach();
        }
        if (isset($request['sizes'])) {
            foreach ($request['size-count'] as $k => $val) {
                if($val != ""){
                    $sizeCount[] = $val;
                }
            }
            $product->sizes()->detach();
            foreach ($request['sizes'] as $key => $value) {
                $size = ProductSize::find($value);
                $product->sizes()->save($size);
                $product->sizes()->where('product_size_id', $size->id)->update(["count" => isset($sizeCount[$key]) ? $sizeCount[$key] : 1]);
            }
        }else{
            $product->sizes()->detach();
        }

        if(isset($product->sizes) && !empty($product->sizes)){
            $count = 0;
            foreach ($product->sizes as $s){
                $count += $s->pivot->count;
            }
            $product->update([
                'count' => $count
            ]);
        }


        session(['success-message' => 'Товар успішно змінено.']);
        return redirect("/admin/products");
    }

    //delete

    public function delProduct($product_id){
        $product = Product::find($product_id);
        $product->delete();
        Storage::disk('public')->deleteDirectory('product-images/'.$product->id);
        session(['success-message' => 'Товар успішно видалено.']);
        return redirect("/admin/products");
    }


                        /*
                         *
                         * Editing/Adding/Saving ORDERS
                         *
                        */


    public  function orderIndex(){
        $orders = OrdersList::orderBy('status', 'asc')->orderBy('created_at', 'desc')->paginate(5);

        if(request()->ajax()){
            return view('admin.order.ajax.ajax-pagination', [
                'orders' => $orders,
                'statuses' => StatusList::all(),
            ])->render();
        }

        return view('admin.order.orders',[
            'user' => $this->getUser(),
            'statuses' => StatusList::all(),
            'orders' =>$orders
        ]);
    }
    public function editOrder($order_id){
        $order = OrdersList::find($order_id);
        if(!$order){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }

        return view('admin.order.edit',[
            'user' => $this->getUser(),
            'statuses' => StatusList::all(),
            'order' => $order,
            'items' =>  $order->items
        ]);
    }

    public function saveEditOrder(Request $request){
        $order = OrdersList::find($request['id']);

        $sum_field = explode('₴', $request['sum-field']);
        $total_cost = intval($sum_field[1]);

        if($request['status-field'] == 3){
            foreach($order->items as $item){
                $product = $item->product->where('id', $item->product_id)->first();
                foreach ($product->sizes as $size) {
                    $sizes = ProductSize::where('name', strval($item->size))->first();
                    if($size->id == $sizes->id){
                        $product->sizes()->where('product_size_id', $sizes->id)->update([
                            'count' =>  $size->pivot->count - $item->count
                        ]);
                    }
                }

                $product->update([
                    'count' => $product->count - $item->count,
                ]);
            }
        }

        $order->update([
            'user_id' => $request['id-field'],
            'name' => $request['name-field'],
            'email' => $request['email-field'],
            'phone' => $request['phone-field'],
            'address' => $request['address-field'],
            'comment' => $request['comment-field'],
            'total_cost' => $total_cost,
            'status' => $request['status-field'],
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        session(['success-message' => 'Замовлення успішно змінено.']);
        return redirect('/admin/orders');
    }

    public function delOrder($order_id){
        session(['success-message' => 'Замовлення успішно видалено.']);
        OrdersList::find($order_id)->delete();
        return redirect("/admin/orders");
    }


                    /*
                       *
                       * Editing/Saving USERS
                       *
                      */

    public function userIndex(){

        $adm_users = User::orderBy('id','asc')->paginate(2);

        if(request()->ajax()){
            return view('admin.user.ajax.ajax-pagination', [
                'adm_users' => $adm_users,
            ])->render();
        }

        return view('admin.user.index', [
            'user' => $this->getUser(),
            'adm_users'=> $adm_users
        ]);
    }

    public function editUser($user_id){
        $user = User::find($user_id);

        if(!$user){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }

        return view('admin.user.edit',[
            'user' => $this->getUser(),
            'adm_user' => $user,
        ]);
    }

    public function saveEditUser(Request $request){
        $user = User::find($request['id']);

        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $superuser = false;
        if($request['admin-field'] == "on"){
            $superuser = true;
        }
        $phone = intval($request['phone-field']);
        $user->update([
            'first_name'=> $request['firstname-field'],
            'last_name'=> $request['lastname-field'],
            'email'=> $request['email-field'],
            'phone'=> $phone,
            'address'=> $request['address-field'],
            'city'=> $request['city-field'],
            'active'=> $active,
            'superuser'=> $superuser,

        ]);
        session(['success-message' => 'Користувача успішно змінено.']);
        return redirect('/admin/users');
    }

    public function delUser($user_id){
         User::find($user_id)->delete();
        session(['success-message' => 'Користувача успішно видалено.']);
         return redirect('/admin/users');
    }

                        /*
                           *
                           * Editing/Adding/Saving COLORS
                           *
                          */

    public function colorIndex(){
        $colors = ProductColor::orderBy('id', 'desc')->get();
        return view('admin.additional-to-products.color.index', [
           'user' => $this->getUser(),
           'colors' =>$colors
        ]);
    }

    public function addColor(){

        return view('admin.additional-to-products.color.add',[
            'user' => $this->getUser(),
        ]);
    }
    public function saveAddColor(Request $request){

        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        ProductColor::create([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active

        ]);
        session(['success-message' => 'Колір успішно додано.']);
        return redirect('/admin/colors');
    }
    public function editColor($color_id){
        $color = ProductColor::find($color_id);
        if(!$color){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }

        return view('admin.additional-to-products.color.edit',[
            'user' => $this->getUser(),
            'color' => $color
        ]);
    }

    public function saveEditColor(Request $request){
        $color = ProductColor::find($request['id']);
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $color->update([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active
        ]);
        session(['success-message' => 'Колір успішно змінено.']);
        return redirect('admin/colors');
    }

    public function delColor($color_id){
        ProductColor::find($color_id)->delete();
        session(['success-message' => 'Колір успішно видалено.']);
        return redirect('admin/colors');
    }


                        /*
                           *
                           * Editing/Adding/Saving BRANDS
                           *
                          */


    public function brandIndex(){
        $brands =  ProductBrand::orderBy('id', 'desc')->get();
        return view('admin.additional-to-products.brand.index', [
            'user' => $this->getUser(),
            'brands' => $brands
        ]);
    }

    public function addBrand(){

        return view('admin.additional-to-products.brand.add',[
            'user' => $this->getUser(),
        ]);
    }
    public function saveAddBrand(Request $request){

        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        ProductBrand::create([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active

        ]);
        session(['success-message' => 'Бренд успішно додано.']);
        return redirect('/admin/brands');
    }
    public function editBrand($brand_id){
        $brand = ProductBrand::find($brand_id);
        if(!$brand){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }
        return view('admin.additional-to-products.brand.edit',[
            'user' => $this->getUser(),
            'brand' => $brand
        ]);
    }

    public function saveEditBrand(Request $request){
        $brand = ProductBrand::find($request['id']);
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $brand->update([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active
        ]);
        session(['success-message' => 'Бренд успішно змінено.']);
        return redirect('admin/brands');
    }

    public function delBrand($brand_id){
        ProductBrand::find($brand_id)->delete();
        session(['success-message' => 'Бренд успішно видалено.']);
        return redirect('admin/brands');
    }


    /*
                           *
                           * Editing/Adding/Saving MATERIALS
                           *
                          */


    public function materialIndex(){
        $materials = ProductMaterial::orderBy('id', 'desc')->get();
        return view('admin.additional-to-products.material.index', [
            'user' => $this->getUser(),
            'materials' => $materials
        ]);
    }

    public function addMaterial(){

        return view('admin.additional-to-products.material.add',[
            'user' => $this->getUser(),
        ]);
    }
    public function saveAddMaterial(Request $request){

        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        ProductMaterial::create([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active

        ]);
        session(['success-message' => 'Матеріал успішно додано.']);
        return redirect('/admin/brands');
    }
    public function editMaterial($material_id){
        $material = ProductMaterial::find($material_id);
        if(!$material){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }
        return view('admin.additional-to-products.material.edit',[
            'user' => $this->getUser(),
            'material' => $material
        ]);
    }

    public function saveEditMaterial(Request $request){
        $material = ProductMaterial::find($request['id']);
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $material->update([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active
        ]);
        session(['success-message' => 'Матеріал успішно змінено.']);
        return redirect('admin/materials');
    }

    public function delMaterial($material_id){
        ProductMaterial::find($material_id)->delete();
        session(['success-message' => 'Матеріал успішно видалено.']);
        return redirect('admin/materials');
    }


    /*
                           *
                           * Editing/Adding/Saving SIZES
                           *
                          */


    public function sizeIndex(){
       $sizes =  ProductSize::orderBy('id', 'desc')->get();
        return view('admin.additional-to-products.size.index', [
            'user' => $this->getUser(),
            'sizes' => $sizes
        ]);
    }

    public function addSize(){

        return view('admin.additional-to-products.size.add',[
            'user' => $this->getUser(),
        ]);
    }
    public function saveAddSize(Request $request){

        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        ProductSize::create([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active

        ]);
        session(['success-message' => 'Розмір успішно додано.']);
        return redirect('/admin/sizes');
    }
    public function editSize($size_id){
        $size = ProductSize::find($size_id);
        if(!$size){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }
        return view('admin.additional-to-products.size.edit',[
            'user' => $this->getUser(),
            'size' => $size
        ]);
    }

    public function saveEditSize(Request $request){
        $size = ProductSize::find($request['id']);
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $size->update([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active
        ]);
        session(['success-message' => 'Розмір успішно змінено.']);
        return redirect('admin/sizes');
    }

    public function delSize($size_id){
        ProductSize::find($size_id)->delete();
        session(['success-message' => 'Розмір успішно видалено.']);
        return redirect('admin/sizes');
    }





}

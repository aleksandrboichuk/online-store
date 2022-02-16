<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\OrdersList;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductColor;
use App\Models\ProductMaterial;
use App\Models\ProductSeason;
use App\Models\ProductSize;
use App\Models\StatusList;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
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




    public function bannerIndex()
    {
        $banners = Banner::orderBy('id', 'desc')->get();
        return view('admin.banner.index',[
            'user'=>$this->getUser(),
            'banners' => $banners
        ]);
    }

    //show adding form

    public function addBanner(){

        return view('admin.banner.add',[
            'user'=>$this->getUser(),
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
            'description' => $request['description-field'],
            'image_url' => $request['main-img-field'],
            'mini_img_url' => $request['mini-img-field'],
            'active' => $active,
        ]);


        return redirect('/admin/banner');
    }

    //editing

    public function editBanner($banner_id){

        return view('admin.banner.edit',[
            'user' => $this->getUser(),
            'banner' =>  Banner::find($banner_id),

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
            'description' => $request['description-field'],
            'image_url' => $request['main-img-field'],
            'mini_img_url' => $request['mini-img-field'],
            'active' => $active,
            'updated_at' => date("Y-m-d H:i:s")
        ]);


        return redirect("/admin/banner");
    }

    //delete

    public function delBanner($banner_id){
        $banner = Banner::find($banner_id);
        $banner->delete();

        return redirect("/admin/banner");
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
            'category_groups' => CategoryGroup::all()
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

        return redirect('/admin/categories');
    }

    //editing

    public function editCategory($category_id){

        return view('admin.category.edit',[
            'user' => $this->getUser(),
            'category' =>  Category::find($category_id),
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
        $category->update([
            'title' => $request['title-field'],
            'name' => $request['name-field'],
            'seo_name' => $request['seo-field'],
            'active' => $active,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        $category->categoryGroups()->where('category_id', $request['id'])->update(["category_group_id" => $request['cat-field']]);

        return redirect("/admin/categories");
    }

    //delete

    public function delCategory($category_id){
        $category = Category::find($category_id);
        $category->delete();

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
            'categories' => Category::all()
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

        return redirect('/admin/subcategories');
    }

    //editing

    public function editSubCategory($subcategory_id){

        return view('admin.subcategory.edit',[
            'user' => $this->getUser(),
            'subcategory' =>  SubCategory::find($subcategory_id),
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
        $subcategory->update([
            'title' => $request['title-field'],
            'name' => $request['name-field'],
            'seo_name' => $request['seo-field'],
            'category_id' =>  $request['cat-field'],
            'active' => $active,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        return redirect("/admin/subcategories");
    }

    //delete

    public function delSubCategory($subcategory_id){
        $subcategory = SubCategory::find($subcategory_id);
        $subcategory->delete();

        return redirect("/admin/subcategories");
    }

            /*
             *
             * Editing/Adding/Saving PRODUCTS
             *
            */


    public function productIndex(){
        $products = Product::orderBy('id', 'desc')->get();
        return view('admin.product.index', [
            'user' => $this->getUser(),
            'products' => $products
        ]);
    }

    //show adding form

    public function addProduct(){

        return view('admin.product.add',[
            'user'=>$this->getUser(),
            'category_groups' => CategoryGroup::all(),
            'categories' => Category::all(),
            'sub_categories' => SubCategory::all(),
            'colors' => ProductColor::all(),
            'seasons' => ProductSeason::all(),
            'brands' => ProductBrand::all(),
            'materials' => ProductMaterial::all(),
            'sizes' => ProductSize::all(),
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
            'preview_img_url' => $request['image-field'],
            'description' => $request['description-field'],
            'price' => $request['price-field'],
            'count' => $request['count-field'],
            'active' => $active,
            'category_group_id' => $request['cat-field'],
            'category_id' => $request['category-field'],
            'category_sub_id' => $request['sub-category-field'],
            'product_color_id' => $request['color-field'],
            'product_season_id' => $request['season-field'],
            'product_brand_id' => $request['brand-field'],
        ]);

        $getProduct = Product::where('name', $request['name-field'])->first();

        foreach ($request['materials'] as $key => $value){
            $getProduct->materials()->attach($getProduct->id,[
                'product_id' => $getProduct->id,
                'product_material_id' => $value
            ]);
        }

        for($i = 0; $i < count($request['sizes']); $i++){
            $getProduct->sizes()->attach($getProduct->id,[
                'product_id' => $getProduct->id,
                'product_size_id' => $request['sizes'][$i],
                'count' =>  $request['size-count'][$i]
            ]);
        }

        return redirect('/admin/products');
    }

    public function editProduct($product_id){

        $product = Product::find($product_id);

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
            'count_sizes' => $count_sizes,
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
        $product->update([
            'name' => $request['name-field'],
            'seo_name' => $request['seo-field'],
            'preview_img_url' => $request['image-field'],
            'description' => $request['description-field'],
            'price' => $request['price-field'],
            'count' => $request['count-field'],
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
        }
        if (isset($request['sizes'])) {

            $product->sizes()->detach();
            foreach ($request['sizes'] as $key => $value) {
                $size = ProductSize::find($value);
                $product->sizes()->save($size);
                $product->sizes()->where('product_size_id', $size->id)->update(["count" => $request['size-count'][$value-1]]);

            }

        }

        return redirect("/admin/products");
    }

    //delete

    public function delProduct($product_id){
        $product = Product::find($product_id);
        $product->delete();
        return redirect("/admin/products");
    }


                /*
                         *
                         * Editing/Adding/Saving ORDERS
                         *
                        */


    public  function orderIndex(){
    $orders = OrdersList::orderBy('status', 'asc')->get();
        return view('admin.order.orders',[
            'user' => $this->getUser(),
            'statuses' => StatusList::all(),
            'orders' =>$orders
        ]);
    }
    public function editOrder($order_id){
        $order = OrdersList::find($order_id);


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
                    $product->sizes()->where('product_size_id', $sizes->id)->update([
                        'count' =>  $size->pivot->count - $item->count
                    ]);
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

        return redirect('/admin/orders');
    }

    public function delOrder($order_id){
        OrdersList::find($order_id)->delete();
        return redirect("/admin/orders");
    }


                    /*
                       *
                       * Editing/Saving USERS
                       *
                      */

    public function userIndex(){

        $adm_users = User::orderBy('id','asc')->get();
        return view('admin.user.index', [
            'user' => $this->getUser(),
            'adm_users'=> $adm_users
        ]);
    }

    public function editUser($user_id){
        $user = User::find($user_id);

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
        return redirect('/admin/users');
    }

    public function delUser($user_id){
         User::find($user_id)->delete();
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
        return redirect('/admin/colors');
    }
    public function editColor($color_id){
        $color = ProductColor::find($color_id);

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
        return redirect('admin/colors');
    }

    public function delColor($color_id){
        ProductColor::find($color_id)->delete();
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
        return redirect('/admin/brands');
    }
    public function editBrand($brand_id){
        $brand = ProductBrand::find($brand_id);

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
        return redirect('admin/brands');
    }

    public function delBrand($brand_id){
        ProductBrand::find($brand_id)->delete();
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
        return redirect('/admin/brands');
    }
    public function editMaterial($material_id){
        $material = ProductMaterial::find($material_id);

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
        return redirect('admin/materials');
    }

    public function delMaterial($material_id){
        ProductMaterial::find($material_id)->delete();
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
        return redirect('/admin/sizes');
    }
    public function editSize($size_id){
        $size = ProductSize::find($size_id);

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
        return redirect('admin/sizes');
    }

    public function delSize($size_id){
        ProductSize::find($size_id)->delete();
        return redirect('admin/sizes');
    }





}

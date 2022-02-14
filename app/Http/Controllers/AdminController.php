<?php

namespace App\Http\Controllers;

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

    // -----------------------------------------------  categories -----------------------------------------------

    public function categoryIndex()
    {
        return view('admin.category.index',[
            'user'=>$this->getUser(),
            'categories' => Category::all()
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


    // -----------------------------------------------  products -----------------------------------------------

    public function productIndex(){
        return view('admin.product.index', [
            'user' => $this->getUser(),
            'products' => Product::all()
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

// --------------------??????

                $product->sizes()->where('product_size_id', $size->id)->update(["count" => $request['size-count'][$key]]);

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

    // -----------------------------------------------  orders -----------------------------------------------

    public  function orderIndex(){

        return view('admin.order.orders',[
            'user' => $this->getUser(),
            'statuses' => StatusList::all(),
            'orders' => OrdersList::all()
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

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductMaterial;
use App\Models\ProductSeason;
use App\Models\ProductSize;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected function validator(array $data){
        $messages = [
            'name-field.min' => 'Заговоловок має містити не менше 3-х символів.',
            'seo-field.min' => 'СЕО має містити не менше 3-х символів.',
            'seo-field.unique' => 'СЕО вже існує.',
            'description-field.min' => 'Опис має містити не менше 10-ти символів.',
            'price-field.min' => 'Ціна має містити не менше 1-го символу.',
        ];
        return Validator::make($data, [
            'name-field' => ['string', 'min:3'],
            'seo-field' => ['string', 'unique:products,seo_name', 'min:3'],
            'description-field' => ['string', 'min:10'],
            'price-field' => ['integer', 'min:1'],
        ], $messages);
    }


    public function index(Request $request,$cat_group = null){
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

    public function add(Request $request){

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

    public function saveAdd(Request $request){
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }


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

        // детальные изобр. все
        if(isset($request['additional-image-field-1'])){
            for($i = 0; $i <= 7; $i++){
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
        if(isset($request['materials'])){
            foreach ($request['materials'] as $key => $value){
                $getProduct->materials()->attach($getProduct->id,[
                    'product_id' => $getProduct->id,
                    'product_material_id' => $value
                ]);
            }
        }else{
            redirect()->back();
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
        return redirect('/admin/products')->with(['success-message' => 'Товар успішно додано.']);
    }




    public function edit(Request $request,$product_id){
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

    public function saveEdit(Request $request){
        $product = Product::find($request['id']);

        // ================ в случае старого сео не делать валидацию на уникальность==============
        if($request['seo-field'] == $product->seo_name){
            $validator = $this->validator($request->except('seo-field'));
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }else{
            // ================ если сео все же изменили то проверить на уникальность ==============
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }
        // ======================= определяем активность чекбокса ======================
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
        $productImages = ProductImage::where('product_id', $product->id)->get();

        // пройтись по полям из запроса, у которых
        // номер совпадает с уже сущ. номером картинки (чтобы если что ее заменить)
        //
        foreach ( $productImages as $key => $img) {
            if(isset($request['additional-image-field-' . ($key)])){
                $imgFile = $request->file('additional-image-field-' . ($key));
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
        return redirect("/admin/products")->with(['success-message' => 'Товар успішно змінено.']);
    }

    //delete

    public function delete($product_id){
        $product = Product::find($product_id);
        $product->delete();
        Storage::disk('public')->deleteDirectory('product-images/'.$product->id);
        return redirect("/admin/products")->with(['success-message' => 'Товар успішно видалено.']);
    }
}

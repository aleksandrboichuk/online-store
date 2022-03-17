<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\UserReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function showProductDetails (Request $request, $group_seo_name, $category_seo_name,$sub_category_seo_name, $product_seo_name){
        if(!$this->getUser()){
            $cart = Cart::where('token', session('_token'))->first();
        }


        $group = CategoryGroup::where('seo_name',$group_seo_name)->where('active', 1)->first();
            if(!$group){
                return response()->view('errors.404', ['user' => Auth::user(), 'cart' => isset($cart) ? $cart : null], 404);
            }
        $category = Category::where('seo_name',$category_seo_name)->where('active', 1)->first();
            if(!$category){
            return response()->view('errors.404', ['user' => Auth::user(), 'cart' => isset($cart) ? $cart : null], 404);
            }
        $sub_category = SubCategory::where('seo_name',$sub_category_seo_name)->where('active', 1)->where('category_id',$category->id)->first();
            if(!$sub_category){
                return response()->view('errors.404', ['user' => Auth::user(), 'cart' => isset($cart) ? $cart : null], 404);
            }
        $product = Product::where('category_group_id', $group->id)->where('active', 1)->where('category_sub_id',$sub_category->id)->where('category_id',$category->id)->where('seo_name',$product_seo_name)->first();
            if(!$product){
                return response()->view('errors.404', ['user' => Auth::user(), 'cart' => isset($cart) ? $cart : null], 404);
            }
        $recommended_products = Product::where('category_group_id', $group->id)->where('active', 1)->inRandomOrder()->take(4)->get();
        $reviews = UserReview::where('product_id', $product->id)->paginate(2);

        $group_brands = $this->getGroupBrand($group->id);

// ------------------------------------------------- AJAX --------------------------------------------------------
        if(!empty($request->productId)) {
            $is_product = false;
            for ($i = 0; $i < count($cart->products); $i++) {
                if ($cart->products[$i]['id'] == $request->productId ) {
                    $product = $cart->products()->where("product_id", $request->productId)->first();
                    for($a = 0; $a < count($product->carts()->pluck('size')); $a++){
                       if($product->carts()->pluck('size')[$a] == $request->productSize){
                           $product->carts()->where("size", $request->productSize)->update(["count" => $request->productCount, "size" => $request->productSize]);
                           $is_product = true;
                           break;
                       }
                    }
                }
            }
            if (!$is_product) {
                $cart->products()->attach($request->productId, [
                    'cart_id' => $cart->id,
                    'product_id' => $request->productId,
                    'count' => $request->productCount,
                    'size' => $request->productSize,
                ]);
            }
        }

        if($request->ajax()){
            return view('ajax.ajax-reviews',[
                'reviews' => $reviews,
                'group' => $group,
                "images"=> ProductImage::all(),
            ])->render();
        }

        return view('product.product',[
            'user'=> $this->getUser(),
            'cart' => $cart,
             'group'  => $group,
             'category'  => $category,
             'sub_category'  => $sub_category,
             'product'  => $product,
             'reviews'  => $reviews,
            'group_categories' => $group->categories,
            'brands' => $group_brands,
            'recommended_products' =>$recommended_products,
            'product_img' => $product->images(),
            "images"=> ProductImage::all(),
        ]);
    }

    public function sendReview($product_id, Request $request){
       $product = Product::find($product_id);

       UserReview::create([
           'product_id' => $product->id,
           'user_id' =>  Auth::id(),
           'grade' => $request['grade'],
           'review' => $request['review']
       ]);

       $reviews = UserReview::where('product_id',$product->id)->get();

       $rating = 0;
        if(isset($reviews) && !empty($reviews)){
            foreach ($reviews as $review) {
                $rating += $review->grade;
               }
            $totalRating = $rating / count($reviews);
        }

        $product->update([
           'rating' => isset($totalRating) ? round($totalRating, 1) : 5.0
       ]);

       return redirect()->back();
    }
}

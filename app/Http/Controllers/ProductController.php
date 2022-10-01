<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\UserReview;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    /**
     * Product page
     *
     * @param Request $request
     * @param string $group_seo_name
     * @param string $category_seo_name
     * @param string $sub_category_seo_name
     * @param string $product_seo_name
     * @return View|Factory|int|string|Application
     */
    public function index (
        Request $request,
        string $group_seo_name,
        string $category_seo_name,
        string $sub_category_seo_name,
        string $product_seo_name
    ): View|Factory|int|string|Application
    {
        $this->group_seo_name = $group_seo_name;
        $this->category_seo_name = $category_seo_name;
        $this->sub_category_seo_name = $sub_category_seo_name;
        $this->product_seo_name = $product_seo_name;

        $this->getPageData();

        // AJAX for adding product to cart
        if($request->get('productId')) {
            if($request->ajax()){
                return $this->setProductToCart($request);
            }
        }

        if($request->ajax()){
            return view('pages.product.ajax.reviews-pagination',[
                'reviews' => $this->pageData['reviews'],
                'group' => $this->pageData['group'],
                "images"=> ProductImage::all(),
            ])->render();
        }

        return view('pages.product.index', $this->pageData);
    }

    /**
     * Getting data for the view
     *
     * @return void
     */
    public function getPageData(): void
    {
        $group = CategoryGroup::getOneBySeoName($this->group_seo_name);

        $category = Category::getOneBySeoName($this->category_seo_name);

        $sub_category = SubCategory::getOneBySeoName($this->sub_category_seo_name);

        $product = Product::getOneBySeoName($this->product_seo_name);

        if(!$group || !$category || !$sub_category || !$product){
            abort(404);
        }

        $this->setBreadcrumbs($this->getBreadcrumbs($group, $category, $sub_category, $product));

        $data = [
            'group'                => $group,
            'category'             => $category,
            'sub_category'         => $sub_category,
            'product'              => $product,
            'group_categories'     => $group->getCategories(),
            'brands'               => $this->getGroupBrands($group->id),
            'stockStatus'          => $product->getProductAmountStatus(),
            'recommended_products' => Product::getRecommendedProducts($group->id),
            'reviews'              => UserReview::getPaginatedProductReviews($product->id),
            'product_img'          => $product->images(),
            'images'               => ProductImage::all(),
            'breadcrumbs'          => $this->breadcrumbs
        ];

        $this->pageData = $data;
    }

    /**
     * Get the breadcrumbs array
     *
     * @param Model $group
     * @param Model $category
     * @param Model $sub_category
     * @param Model $product
     * @return array[]
     */
    private function getBreadcrumbs(Model $group, Model $category, Model $sub_category, Model $product): array
    {
        return [
            [$group->name,        route('index', $group->seo_name)],
            [$category->name,     route('category', [$group->seo_name, $category->seo_name])],
            [$sub_category->name, route('subcategory', [$group->seo_name, $category->seo_name, $sub_category->seo_name])],
            [$product->name],
        ];
    }

    /**
     * Adding or updating product in the cart
     *
     * @param Request $request
     * @return int
     */
    private function setProductToCart(Request  $request): int
    {
        $cart = $this->getCart();

        $product_id = $request->get('productId');
        $product_size = $request->get('productSize');
        $product_count = $request->get('productCount');

        $was_product_updated = $cart->updateCartProductCount($product_id, $product_size, $product_count);

        if (!$was_product_updated) {
           $cart->addProductToTheCart($product_id, $product_size, $product_count);
        }

        return $cart->products()->count();
    }
}

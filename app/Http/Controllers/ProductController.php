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
     * @param string $category_seo_name
     * @param string $product_seo_name
     * @return View|Factory|int|string|Application
     */
    public function index (
        Request $request,
        string $category_seo_name,
        string $product_seo_name
    ): View|Factory|int|string|Application
    {
        $this->setCategorySeoName($category_seo_name);

        $this->setProductSeoName($product_seo_name);

        $this->setPageData();

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
    public function setPageData(): void
    {
        $category = Category::getOneBySeoName($this->category_seo_name);

        $product = $category ? $category->getProductBySeoName($this->product_seo_name) : abort(404);

        $group = $category->categoryGroup;

        $parentCategory = $category->oarent;

        $this->setBreadcrumbs($this->getBreadcrumbs($group, $category, $parentCategory, $product));

        $data = [
            'group'                => $group,
            'parentCategory'       => $parentCategory,
            'category'             => $category,
            'product'              => $product,
            'group_categories'     => $group->getCategoriesForSidebar(),
            'brands'               => $group->getBrands(),
            'stockStatus'          => $product->getProductAmountStatus(),
            'recommended_products' => Product::getRecommendedProducts($group->id),
            'reviews'              => UserReview::getPaginatedProductReviews($product->id),
            'product_img'          => $product->images,
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
     * @param Model|null $parentCategory
     * @param Model $product
     * @return array[]
     */
    private function getBreadcrumbs(Model $group, Model $category, Model|null $parentCategory, Model $product): array
    {
        $breadcrumbs =  [
            [$group->name,          route('index', $group->seo_name)]
        ];

        if($parentCategory){
            $breadcrumbs[] = [$parentCategory->name, $parentCategory->url];
        }

        array_push(
            $breadcrumbs,
            [$category->name, $category->url],
            [$product->name]
        );

        return $breadcrumbs;

    }
}

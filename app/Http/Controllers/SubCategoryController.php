<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\ProductImage;
use App\Models\SubCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Страница под-категории
     *
     * @param Request $request
     * @param string $group_seo_name
     * @param string $category_seo_name
     * @param string $sub_category_seo_name
     * @return Application|Factory|View|string
     */
    public function index(
        Request $request,
        string $group_seo_name,
        string $category_seo_name,
        string $sub_category_seo_name
    ): View|Factory|string|Application
    {

        $this->group_seo_name = $group_seo_name;
        $this->category_seo_name = $category_seo_name;
        $this->sub_category_seo_name = $sub_category_seo_name;

        $this->getPageData();

        // AJAX
        if($request->ajax()){
            return view('ajax.ajax',[
                'products' => $this->pageData['products'],
                'group'    => $this->pageData['group'],
                'images'   => ProductImage::all(),
            ])->render();
        }

        return view('SubCategory.subcategory', $this->pageData);
    }

    /**
     * Получение всех данных для вьюхи
     *
     * @return void
     */
    public function getPageData(): void
    {
        $group = CategoryGroup::getOneBySeoName($this->group_seo_name);

        $category = Category::getOneBySeoName($this->category_seo_name);

        $sub_category = SubCategory::getOneBySeoName($this->sub_category_seo_name);

        if(!$group || !$category || !$sub_category){
            abort(404);
        }

        $products = $sub_category->getPaginateProducts(8);

        $brands = $this->getGroupBrands($group->id);

        $data = [
            'group'            => $group,
            'category'         => $category,
            'sub_category'     => $sub_category,
            'products'         => $products,
            'group_categories' => $group->getCategories(),
            'brands'           => $brands
        ];

        $this->pageData = array_merge($data, $this->getProductProperties());
    }
}

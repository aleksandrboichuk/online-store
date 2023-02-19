<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\ProductImage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * Category page
     *
     * @param string $group_seo_name
     * @param string $category_seo_name
     * @param string|null $subcategory_seo_name
     * @return Application|Factory|View|string
     */
    public function index(
        string $group_seo_name,
        string $category_seo_name,
        string|null $subcategory_seo_name = null
    ): Application|Factory|View|string
    {
        $this->setCategoryGroupSeoName($group_seo_name);

        $this->setCategorySeoName($category_seo_name);

        $this->setSubCategorySeoName($subcategory_seo_name);

        $this->setPageData();

        if(request()->ajax()){
            return view('pages.components.ajax.pagination',[
                'products' => $this->pageData['products'],
                'group' => $this->pageData['group'],
                "images"=> ProductImage::all(),
            ])->render();
        }

        return view('pages.category.index', $this->pageData);
    }

    /**
     * Sets page data for view
     *
     * @return void
     */
    public function setPageData(): void
    {
        $group = CategoryGroup::getOneBySeoName($this->group_seo_name);

        $category = $group ? $group->getChildCategoryBySeoName($this->category_seo_name) : abort(404);

        $subcategory = $category ? $category->getChildCategoryBySeoName($this->subcategory_seo_name) : abort(404);

        if($this->subcategory_seo_name && !$subcategory){
            abort(404);
        }

        $products = ($subcategory ?? $category)->getPaginateProducts(8);

        $this->setBreadcrumbs($this->getBreadcrumbs($group, $category, $subcategory));

        $data = [
            'group'            => $group,
            'category'         => $category,
            'subcategory'      => $subcategory,
            'products'         => $products,
            'group_categories' => $group->getCategoriesForSidebar(),
            'brands'           => $group->getBrands(),
            'breadcrumbs'      => $this->breadcrumbs
        ];

        $this->pageData = array_merge($data, $this->getProductProperties());
    }

    /**
     * Get the breadcrumbs array
     *
     * @param Model $group
     * @param Model $category
     * @param Model|null $subcategory
     * @return array[]
     */
    private function getBreadcrumbs(Model $group, Model $category, Model|null $subcategory = null): array
    {
        $breadcrumbs = [
            [$group->name, route('index', $group->seo_name)]
        ];

        if($subcategory){
            array_push(
                $breadcrumbs,
                [$category->name, $category->url],
                [$subcategory->name]
            );
        }else{
            $breadcrumbs[] = [$category->name];
        }

        return $breadcrumbs;
    }
}

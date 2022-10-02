<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\ProductImage;
use App\Models\SubCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
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

        $this->setCategoryGroupSeoName($group_seo_name);
        $this->setCategorySeoName($category_seo_name);
        $this->setSubCategorySeoName($sub_category_seo_name);

        $this->setPageData();

        // AJAX
        if($request->ajax()){
            return view('pages.components.ajax.pagination',[
                'products' => $this->pageData['products'],
                'group'    => $this->pageData['group'],
                'images'   => ProductImage::all(),
            ])->render();
        }

        return view('pages.subcategory.index', $this->pageData);
    }

    /**
     * Получение всех данных для вьюхи
     *
     * @return void
     */
    public function setPageData(): void
    {
        $group = CategoryGroup::getOneBySeoName($this->group_seo_name);

        $category = Category::getOneBySeoName($this->category_seo_name);

        $sub_category = SubCategory::getOneBySeoName($this->sub_category_seo_name);

        if(!$group || !$category || !$sub_category){
            abort(404);
        }

        $this->setBreadcrumbs($this->getBreadcrumbs($group, $category, $sub_category));

        $data = [
            'group'            => $group,
            'category'         => $category,
            'sub_category'     => $sub_category,
            'products'         => $sub_category->getPaginateProducts(8),
            'group_categories' => $group->getCategories(),
            'brands'           => $this->getGroupBrands($group->id),
            'breadcrumbs'      => $this->breadcrumbs
        ];

        $this->pageData = array_merge($data, $this->getProductProperties());
    }

    /**
     * Get the breadcrumbs array
     *
     * @param Model $group
     * @param Model $category
     * @param Model $sub_category
     * @return array[]
     */
    private function getBreadcrumbs(Model $group, Model $category, Model $sub_category): array
    {
        return [
            [$group->name,        route('index', $group->seo_name)],
            [$category->name,     route('category', [$group->seo_name, $category->seo_name])],
            [$sub_category->name],
        ];
    }
}

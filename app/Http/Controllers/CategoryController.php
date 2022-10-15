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
     * @param Request $request
     * @param $group_seo_name
     * @param $category_seo_name
     * @return Application|Factory|View|string
     */
    public function index(Request $request, $group_seo_name, $category_seo_name): Application|Factory|View|string
    {
        $this->setCategoryGroupSeoName($group_seo_name);

        $this->setCategorySeoName($category_seo_name);

        $this->setPageData();

        if($request->ajax()){
            return view('ajax.ajax',[
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

        $category = Category::getOneBySeoName($this->category_seo_name);

        if(!$group || !$category){
            abort(404);
        }

        $this->setBreadcrumbs($this->getBreadcrumbs($group, $category));

        $data = [
            'group'            => $group,
            'category'         => $category,
            'products'         => $category->getPaginateProducts(8),
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
     * @return array[]
     */
    private function getBreadcrumbs(Model $group, Model $category): array
    {
        return [
            [$group->name, route('index', $group->seo_name)],
            [$category->name],
        ];
    }
}

<?php

namespace App\Http\Controllers;


use App\Models\Banner;
use App\Models\CategoryGroup;
use App\Models\ProductImage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoryGroupController extends Controller
{

    /**
     * Главная страница
     *
     * @param Request $request
     * @param $group_seo_name
     * @return Application|Factory|View|string
     */
    public function index(Request $request, $group_seo_name): Application|Factory|View|string
    {
        $this->group_seo_name = $group_seo_name;

        $this->getPageData();

        // AJAX
        if($request->ajax()){
            return view('pages.components.pagination',[
                'products' => $this->pageData['products'],
                'group' => $this->pageData['group'],
                "images"=> ProductImage::all(),
            ])->render();
        }

        return view('pages.main.index', $this->pageData);
    }

    /**
     * Получение всех данных для вьюхи
     *
     * @return void
     */
    public function getPageData(): void
    {
        $group = CategoryGroup::getOneBySeoName($this->group_seo_name);

        $brands = $this->getGroupBrands($group->id);

        if(!$group){
            abort(404);
        }

        $products = $group->getPaginateProducts(8);

        $data = [
            'banners'          => Banner::getBanners($group->id),
            'group'            => $group,
            'products'         => $products,
            'group_categories' => $group->getCategories(),
            'brands'           => $brands
        ];

        $this->pageData = array_merge($data, $this->getProductProperties());
    }
}

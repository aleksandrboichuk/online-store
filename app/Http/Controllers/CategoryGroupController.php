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
     * Main page
     *
     * @param Request $request
     * @param $group_seo_name
     * @return Application|Factory|View|string
     */
    public function index(Request $request, $group_seo_name): Application|Factory|View|string
    {
        $this->setCategoryGroupSeoName($group_seo_name);

        $this->setPageData();

        // AJAX
        if($request->ajax()){
            return view('pages.components.ajax.pagination',[
                'products' => $this->pageData['products'],
                'group' => $this->pageData['group'],
                "images"=> ProductImage::all(),
            ])->render();
        }

        return view('pages.main.index', $this->pageData);
    }

    /**
     * Sets page data for view
     *
     * @return void
     */
    public function setPageData(): void
    {
        $group = CategoryGroup::getOneBySeoName($this->group_seo_name);

        if(!$group){
            abort(404);
        }

        $brands = $this->getGroupBrands($group->id);

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

<?php

namespace App\Http\Controllers;


use App\Models\Banner;
use App\Models\CategoryGroup;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class PromotionController extends Controller
{

    /**
     * Страница акции (баннера)
     *
     * @param string $group_seo_name
     * @param string $banner_seo_name
     * @return View
     */
    public function index(string $group_seo_name, string $banner_seo_name): View
    {
        $this->group_seo_name = $group_seo_name;
        $this->banner_seo_name = $banner_seo_name;

        $this->getPageData();

        return view('promotions.index', $this->pageData);
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

        $banner = Banner::getBannerBySeoName($this->banner_seo_name);

        $products = Product::getProductsForPromotion($banner->id, $group->id, 6);

        $data = [
            'banner'=> $banner ,
            'products' => $products,
            'group' => $group,
            'group_categories' => $group->categories,
            'brands' => $brands,
        ];

        $this->pageData = array_merge($data, $this->getProductProperties());
    }
}

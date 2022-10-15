<?php

namespace App\Http\Controllers;


use App\Models\Banner;
use App\Models\CategoryGroup;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

class PromotionController extends Controller
{

    /**
     * Promotion (banner) page
     *
     * @param string $group_seo_name
     * @param string $banner_seo_name
     * @return View
     */
    public function index(string $group_seo_name, string $banner_seo_name): View
    {
        $this->setCategoryGroupSeoName($group_seo_name);
        $this->setBannerSeoName($banner_seo_name);

        $this->setPageData();

        return view('pages.promotions.index', $this->pageData);
    }

    /**
     * Getting data necessary for view
     *
     * @return void
     */
    public function setPageData(): void
    {
        $group = CategoryGroup::getOneBySeoName($this->group_seo_name);

        $brands = $this->getGroupBrands($group->id);

        $banner = Banner::getBannerBySeoName($this->banner_seo_name);

        $products = Product::getProductsForPromotion($banner->id, $group->id, 6);

        $this->setBreadcrumbs($this->getBreadcrumbs($group, $banner));

        $data = [
            'banner'           => $banner ,
            'products'         => $products,
            'group'            => $group,
            'group_categories' => $group->categories,
            'brands'           => $brands,
            'breadcrumbs'      => $this->breadcrumbs
        ];

        $this->pageData = array_merge($data, $this->getProductProperties());
    }

    /**
     * Get the breadcrumbs array
     *
     * @param Model $group
     * @param Model $banner
     * @return array[]
     */
    private function getBreadcrumbs(Model $group, Model $banner): array
    {
        return [
            [$group->name, route('index', $group->seo_name)],
            [$banner->title],
        ];
    }
}

<?php

namespace App\Http\Controllers;


use App\Models\Banner;
use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\ProductBrand;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductMaterial;
use App\Models\ProductSeason;
use App\Models\ProductSize;
use App\Models\SubCategory;
use App\Services\ElasticSearchService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SearchController extends Controller
{

    /**
     * Глобальный параметр сортировки
     *
     * @var string
     */
    private string $sorting;

    /**
     * Клиент эластика
     *
     * @var ElasticSearchService
     */
    protected ElasticSearchService $elasticSearch;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->elasticSearch = new ElasticSearchService();
    }

    /**
     * Страница поиска
     *
     * @param string $group_seo_name
     * @return Application|Factory|View|string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(string $group_seo_name): View|Factory|string|Application
    {
        $this->group_seo_name = $group_seo_name;

        $this->sorting = request()->has('orderBy') && !empty(request()->get('orderBy')) ? request()->get('orderBy') : null;

        $this->getPageData();

        if($this->sorting && request()->ajax()){
            return view('ajax.ajax',[
                'products' => $this->pageData['products'],
                'group' => $this->pageData['group'],
                "images"=> ProductImage::all(),
            ])->render();
        }

        return view('search.cg-search', $this->pageData);
    }


    /**
     * Осуществление поиска в зависимости от сущестовования сортировки
     *
     * @return LengthAwarePaginator
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function searchProducts(): LengthAwarePaginator
    {
        return $this->elasticSearch->search($this->group_seo_name, \request()->get('q'), $this->sorting ?? 'none');
    }

    /**
     * Получение всех данных для вьюхи
     *
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getPageData(): void
    {
        $group = CategoryGroup::getGroupBySeoName($this->group_seo_name);

        if(!$group){
            abort(404);
        }

        $products = $this->searchProducts();

        $brands = $this->getGroupBrands($group->id);

        $data = [
            'group'            => $group,
            'products'         => $products,
            'group_categories' => $group->getCategories(),
            'brands'           => $brands
        ];

        $this->pageData = array_merge($data, $this->getProductProperties());
    }
}

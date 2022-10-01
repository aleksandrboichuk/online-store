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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SearchFilterController extends Controller
{

    /**
     * Флаг присутствия страницы акции
     *
     * @var bool
     */
    private bool $promotion;

    /**
     * Модель акции (если она есть)
     *
     * @var  Model|null
     */
    private  Model|null $promotionBanner;

    /**
     * Группа категорий
     *
     * @var  Model|null
     */
    private  Model|null $group;

    /**
     * Категория
     *
     * @var  Model|null
     */
    private Model|null $category;

    /**
     * Подкатегория
     *
     * @var  Model|null
     */
    private  Model|null $subCategory;

    /**
     * Глобальный массив с запросом в эластик
     *
     * @var array
     */
    private array $arrElasticQuery;

    /**
     * Тип строгости поиска в эластика
     *
     * @var string
     */
    private string $filterType;

    /**
     * Клиент эластика
     *
     * @var ElasticSearchService
     */
    protected ElasticSearchService $elasticSearch;

    /**
     * Вьюха
     *
     * @var string
     */
    protected string $view;

    /**
     * Массив с параметрами запроса
     *
     * @var array
     */
    protected array $arrQuery;

    /**
     * Массив с запросом в эластик
     *
     * @var array
     */
    protected array $must;

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
     * @return Application|Factory|View|string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): View|Factory|string|Application
    {

        $this->arrQuery = request()->query();

        $this->filterType = 'must';

        $this->setCategoryAndPromotionVariables();

        $this->setElasticQueryByQueryString();

        $this->setSeoNamesVariables();

        $this->setMustArray();

        $this->getPageData();

        if(request()->ajax()){
            return view('pages.components.ajax.pagination',[
                'products' => $this->pageData['products'],
                'group' => $this->pageData['group'],
                "images"=> ProductImage::all(),
            ])->render();
        }


        return view($this->view, $this->pageData);
    }

    /**
     * Установка must массива для запроса в эластик
     *
     * @return void
     */
    private function setMustArray(): void
    {
        if(!in_array($this->group_seo_name, ['women', 'men', 'girls', 'boys'])){

            $this->setDefaultMustArray();

        }else{
            if($this->promotion){
                if($this->group_seo_name != '') {
                    // если мы на странице акции
                    $this->setMustArrayByPromotion();
                }
            }else{
                if(
                    $this->group_seo_name != ''
                    && $this->category_seo_name === ''
                    && $this->sub_category_seo_name === ''
                ){
                    // если мы на странице группы категорий
                    $this->setMustArrayWithGroup();

                }elseif(
                    $this->group_seo_name != ''
                    && $this->category_seo_name != ''
                    && $this->sub_category_seo_name === ''
                ){
                    // если мы на странице категории
                    $this->setMustArrayWithGroupAndCategory();

                }elseif(
                    $this->group_seo_name != ''
                    && $this->category_seo_name != ''
                    && $this->sub_category_seo_name != ''
                ){
                    // если мы на странице подкатегории
                    $this->setMustArrayWithAllCategories();

                }
            }

        }
    }

    /**
     * Осуществление поиска в зависимости от сущестовования сортировки
     *
     * @var string|null $sorting
     * @return LengthAwarePaginator
     */
    private function searchProductsByFilters(string|null $sorting): LengthAwarePaginator
    {
        return $this->elasticSearch->searchByFilters($this->must ?? [], $this->arrElasticQuery, $sorting ?? 'none');
    }

    /**
     * Устанавливаем массив в случае если мы на странице подкатегории
     *
     * @return void
     */
    private function setMustArrayWithAllCategories(): void
    {
        $this->must = [
            ['match' => ['product_category_group' => $this->group->id]],
            ['match' => ['product_category' => $this->category->id]],
            ['match' => ['product_category_sub' => $this->subCategory->id]]
        ];
        $this->view = 'pages.subcategory.index';
    }

    /**
     * Устанавливаем массив в случае если мы на странице категории
     *
     * @return void
     */
    private function setMustArrayWithGroupAndCategory(): void
    {
        $this->must = [
            ['match' => ['product_category_group' => $this->group->id]],
            ['match' => ['product_category' => $this->category->id]]
        ];
        $this->view = 'pages.category.index';
    }

    /**
     * Устанавливаем массив с запросом в случае если мы на главной странице
     *
     * @return void
     */
    private function setMustArrayWithGroup(): void
    {
        $this->view = 'index';
        $this->must = [
            ['match' => ['cg_seo_name' => $this->group_seo_name]],
        ];
    }

    /**
     * Устанавливаем массив в случае если мы на странице акции
     *
     * @return void
     */
    private function setMustArrayByPromotion(): void
    {
        $this->must = [
            ['match' => ['cg_seo_name' => $this->group_seo_name]],
            ['match' => ['banner_id' => $this->promotionBanner->id]],
        ];
        $this->view = 'pages.promotions.index';
    }

    /**
     * Установка дефолтного массива с запросом в эластик
     *
     * @return void
     */
    private function setDefaultMustArray(): void
    {
        $this->view = 'index';
        $this->must = ['match' => ['cg_seo_name' => "women"]];
    }

    /**
     * Устанавливаем сео имена категорий для использования в формировании запроса
     *
     * @return void
     */
    private function setSeoNamesVariables(): void
    {
        $this->group_seo_name = $this->group ? $this->group->seo_name : '';
        $this->category_seo_name = $this->category ? $this->category->seo_name : '';
        $this->sub_category_seo_name = $this->subCategory ? $this->subCategory->seo_name : '';
    }

    /**
     * Устанавливает глобальный массив с запросом в эластик на основе строки запроса
     *
     * @return void
     */
    private function setElasticQueryByQueryString(): void
    {
        if(isset($this->arrQuery['colors'])){
            $this->setColorsToElasticQuery();
        }
        if(isset($this->arrQuery['brands'])){
            $this->setBrandsToElasticQuery();
        }
        if(isset($this->arrQuery['seasons'])){
            $this->setSeasonsToElasticQuery();
        }
        if(isset($this->arrQuery['materials'])){
            $this->setMaterialsToElasticQuery();
        }
        if(isset($this->arrQuery['sizes'])){
            $this->setSizesToElasticQuery();
        }

        if(isset($this->arrQuery['priceFrom']) && isset($arrQuery['priceTo'])){
            $this->setPriceRangeToElasticQuery();
        }
    }

    /**
     * Устанавливает промежуток цены в запрос к эластику
     *
     * @return void
     */
    private function setPriceRangeToElasticQuery(): void
    {
        $requestPriceFrom = explode(' ', $this->arrQuery['priceFrom']);
        $requestPriceTo = explode(' ', $this->arrQuery['priceTo']);

        if(count($requestPriceFrom) > 1){
            $priceFrom = $requestPriceFrom[0];
        }else{
            $priceFrom = $this->arrQuery['priceFrom'];
        }
        if(count($requestPriceTo) > 1){
            $priceTo = $requestPriceTo[0];
        }else{
            $priceTo = $this->arrQuery['priceTo'];
        }

        $this->arrElasticQuery["bool"][$this->filterType][] =  [
            'range' => [
                'price' => [
                    "gte" => $priceFrom,
                    "lte" => $priceTo
                ]
            ]
        ];
    }

    /**
     * Устанавливает цвета в большой массив с запросом в эластик
     *
     * @return void
     */
    private function setColorsToElasticQuery(): void
    {
        $requestColors = explode(' ', $this->arrQuery['colors']);
        $colors = [];

        foreach ($requestColors as $rc){
            $colorModel = ProductColor::getOneBySeoName($rc);
            $colors[] = $colorModel->id;
        }
        $this->arrElasticQuery["bool"][$this->filterType][] =  [
            'terms' => [
                'pc_id' => $colors
            ]
        ];
    }

    /**
     * Устанавливает цвета в большой массив с запросом в эластик
     *
     * @return void
     */
    private function setBrandsToElasticQuery(): void
    {
        $requestBrands =  explode(' ', $this->arrQuery['brands']);
        $brands = [];
        foreach ($requestBrands as $rb){
            $brandModel = ProductBrand::getOneBySeoName($rb);
            $brands[] = $brandModel->id;
        }
        $this->arrElasticQuery["bool"][$this->filterType][] =  [
            'terms' => [
                'pb_id' => $brands
            ]
        ];
    }

    /**
     * Устанавливает цвета в большой массив с запросом в эластик
     *
     * @return void
     */
    private function setSeasonsToElasticQuery(): void
    {
        $requestSeasons =  explode(' ', $this->arrQuery['seasons']);
        $seasons = [];
        foreach ($requestSeasons as $rs){
            $seasonModel = ProductSeason::getOneBySeoName($rs);
            $seasons[] = $seasonModel->id;
        }
        $this->arrElasticQuery["bool"][$this->filterType][] =  [
            'terms' => [
                'ps_id' => $seasons
            ]
        ];
    }

    /**
     * Устанавливает цвета в большой массив с запросом в эластик
     *
     * @return void
     */
    private function setMaterialsToElasticQuery(): void
    {
        $requestMaterials =  explode(' ', $this->arrQuery['materials']);
        $materials = [];
        foreach ($requestMaterials as $rm){
            $materialModel = ProductMaterial::getOneBySeoName($rm);
            $materials[] = $materialModel->id;
        }
        $this->arrElasticQuery["bool"][$this->filterType][] =  [
            'terms' => [
                'pm_id' => $materials
            ]
        ];
    }

    /**
     * Устанавливает цвета в большой массив с запросом в эластик
     *
     * @return void
     */
    private function setSizesToElasticQuery(): void
    {
        $requestSizes  =  explode(' ', $this->arrQuery['sizes']);
        $sizes = [];
        foreach ($requestSizes as $rsize){
            $sizeModel = ProductSize::getOneBySeoName($rsize);
            $sizes[] = $sizeModel->id;
        }
        $this->arrElasticQuery["bool"][$this->filterType][] =  [
            'terms' => [
                'psize_id' => $sizes
            ]
        ];
    }

    /**
     * Устанавливает базовые глобальные переменные категорий и возможно акции
     *
     * @return void
     */
    private function setCategoryAndPromotionVariables(): void
    {
        $this->promotion = false;

        //в зависимости от присутствия признака того, что запрос со страницы акций
        // выборка происходит по определенным сегментам строки запроса
        if(request()->segment(1) == 'promotions'){

            $this->promotion = true;
            $this->promotionBanner = Banner::getOneBySeoName(request()->segment(3));
            $this->group = CategoryGroup::getOneBySeoName(request()->segment(2));

        }else{

            $this->group = CategoryGroup::getOneBySeoName(request()->segment(2));

            if(request()->segment(3)){
                $this->category = Category::getOneBySeoName(request()->segment(3));
            }

            if(request()->segment(4)){
                $this->subCategory =  SubCategory::getOneBySeoName(request()->segment(4));
            }
        }
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
        if(!$this->group){
            abort(404);
        }

        $sorting = request()->has('orderBy') && !empty(request()->get('orderBy')) ? request()->get('orderBy') : null;

        if($this->view == 'index'){
            $banners = Banner::getBannersByGroupId($this->group->id);
        }

        $this->setBreadcrumbs($this->getBreadcrumbs());

        $data  = [
            'group'            => $this->group,
            'products'         => $this->searchProductsByFilters($sorting),
            'group_categories' => $this->group->getCategories(),
            'brands'           => $this->getGroupBrands($this->group->id),
            'category'         => $this->category ?? null,
            'sub_category'     => $this->subCategory ?? null,
            'banner'           => $this->promotionBanner ?? null,
            'banners'          => $banners ?? null,
            'breadcrumbs'      => $this->breadcrumbs
        ];

        $this->pageData = array_merge($data, $this->getProductProperties());
    }

    /**
     * Get the breadcrumbs array
     *
     * @return array[]
     */
    private function getBreadcrumbs(): array
    {
        $breadcrumbs = [];

        if($this->group){
            $breadcrumbs[] = [
                $this->group->name,
                route('index', $this->group->seo_name)
            ];
        }

        if($this->category){
            $breadcrumbs[] = [
                $this->category->name,
                route('category', [$this->group->seo_name, $this->category->seo_name])
            ];
        }

        if($this->subCategory){
            $breadcrumbs[] = [$this->subCategory->name];
        }

        if($this->promotionBanner){
            $breadcrumbs[] = [
                $this->promotionBanner->name,
            ];
        }

        return $breadcrumbs;
    }
}

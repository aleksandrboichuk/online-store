<?php

namespace App\Http\Controllers;


use App\Models\Banner;
use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\Brand;
use App\Models\Color;
use App\Models\ProductImage;
use App\Models\Material;
use App\Models\Season;
use App\Models\Size;
use App\Models\SubCategory;
use App\Services\ElasticSearchService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SearchController extends Controller
{

    /**
     * Parameter of sorting
     *
     * @var string|null
     */
    private string|null $sorting;

    /**
     * Elasticsearch Client
     *
     * @var ElasticSearchService
     */
    protected ElasticSearchService $elasticSearch;

    /**
     * Construct
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct()
    {
        $this->setElasticClient();

        $this->setSorting();
    }

    /**
     * Search page
     *
     * @param string $group_seo_name
     * @return Application|Factory|View|string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(string $group_seo_name): View|Factory|string|Application
    {
        $this->setCategoryGroupSeoName($group_seo_name);

        $this->setPageData();

        if($this->sorting && request()->ajax()){
            return view('pages.components.ajax.pagination',[
                'products' => $this->pageData['products'],
                'group' => $this->pageData['group'],
                "images"=> ProductImage::all(),
            ])->render();
        }

        return view('pages.search.pages.category-group', $this->pageData);
    }


    /**
     * Search products by elasticsearch
     *
     * @return LengthAwarePaginator
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function searchProducts(): LengthAwarePaginator
    {
        return $this->elasticSearch->search($this->group_seo_name, \request()->get('q'), $this->sorting);
    }

    /**
     * Getting necessary data for the view
     *
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function setPageData(): void
    {
        $group = CategoryGroup::getOneBySeoName($this->group_seo_name);

        if(!$group){
            abort(404);
        }

        $this->setBreadcrumbs($this->getBreadcrumbs($group));

        $data = [
            'group'            => $group,
            'products'         => $this->searchProducts(),
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
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getBreadcrumbs(Model $group): array
    {
        return [
            [$group->name, route('index', $group->seo_name)],
            ["Пошук: \"".\request()->get('q')."\""],
        ];
    }

    /**
     * Sets sorting variable
     *
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function setSorting(): void
    {
        $this->sorting = request()->has('orderBy') && !empty(request()->get('orderBy'))
            ? request()->get('orderBy')
            : null;
    }

    /**
     * Sets elasticsearch client service
     *
     * @return void
     */
    private function setElasticClient(): void
    {
        $this->elasticSearch = new ElasticSearchService();
    }
}

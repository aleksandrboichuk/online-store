<?php
namespace App\Services;


use App\Models\Product;
//use Elasticsearch\Client;
//use Elasticsearch\ClientBuilder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class ElasticSearchService
{

    /**
     * Клиент эластика
     *
     * @var Client
     */
    private $elasticsearch;


    public function __construct()
    {
        $this->elasticsearch = ClientBuilder::create()
            ->setHosts(config('services.search.hosts'))
            ->build();
    }


    /**
     * Поиск по строке запроса
     *
     * @param string $seo_name
     * @param string $query
     * @param string $sort
     * @return LengthAwarePaginator
     */
    public function search(string $seo_name, string $query = "", string $sort = "none"): LengthAwarePaginator
    {
        return $this->buildCollection(
          $this->searchOnElasticsearch($seo_name, $query), $sort
        );
    }

    /**
     * Запрос в эластик для поиска по строке запроса
     *
     * @param string $seo_name
     * @param string $query
     * @return array|callable
     */
    private function searchOnElasticsearch(string $seo_name, string $query): array
    {
        //dd($query);
        //['match' => ['cg_seo_name' => $seo_names]]
        return $this->elasticsearch->search([
            'index' => 'elastic_products',
            'type' => '_doc',
           'body' => [
               'size'=> 1000,
               'query' => [
                   'bool' => [
                       'must' => [
                           ['match' => ['cg_seo_name' => $seo_name]],
                           ['multi_match' => [
                               'fields' => ['name'],
                               'query' => $query,
                               'fuzziness' => 'AUTO'
                           ]]
                       ],
                   ]
               ],
           ],
        ]);
    }


    /**
     * Фильтрация
     *
     * @param array $must
     * @param array $arData
     * @param string $sort
     * @return LengthAwarePaginator
     */
    public function searchByFilters(
        array $must = [['match' => ['cg_seo_name' => "women"]]],
        array $arData = [],
        string $sort = "none"
    ): LengthAwarePaginator
    {
        return $this->buildCollection(
            $this->searchByFiltersOnElasticsearch($must, $arData), $sort
        );
    }

    /**
     * Запрос в эластик для фильтрации
     *
     * @param array $must
     * @param array $arrData
     * @return array|callable
     */
    private function searchByFiltersOnElasticsearch(array $must, array $arrData){

        if(empty($arrData)){
            $arrData = ["bool" => ["must" => ["terms" => ["active" => [1]]]]];
        }
//        $defaultMust = [['match' => ['cg_seo_name' => "women"]]];
        return $this->elasticsearch->search([
            'index' => 'elastic_products',
            'type' => '_doc',
            'body' => [
                'size'=> 1000,
                'query' => [
                    'bool'=>[
                        'must' => $must,
                        'filter' => [
                            $arrData
                        ]
                    ]
                ],
            ],
        ]);
    }


    /**
     * Создание коллекции с результатами поиска
     *
     * @param array $items
     * @param string $sort
     * @return LengthAwarePaginator
     */
    private function buildCollection(array $items, string $sort): LengthAwarePaginator
    {
        $elements = Arr::pluck($items['hits']['hits'], '_source');
        $ids = [];
        foreach ($elements as $element) {
            $ids[] = $element['id'];
        }

        // сортировка
        $products = $this->getSortedProducts($ids, $sort);

        // пагинация
        return $this->paginate($products, 8);
    }

    /**
     * Кастомная пагинация
     *
     * @param $items
     * @param $perPage
     * @param $page
     * @param $options
     * @return LengthAwarePaginator
     */
    private function paginate($items, $perPage = 9, $page = null, $options = [])
    {
        $page = $page ?: (\Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    /**
     * Получение отсортированных продуктов в зависимости от пришедшего типа сортировки
     *
     * @param array $ids
     * @param string $sorting
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getSortedProducts(array $ids, string $sorting): \Illuminate\Database\Eloquent\Collection
    {
        switch ($sorting)
        {
            case 'popularity':
                return  Product::query()->findMany(array_unique($ids))->sortByDesc('popularity');
            case 'price-asc':
                return  Product::query()->findMany(array_unique($ids))->sortBy('price');
            case 'price-desc':
                return Product::query()->findMany(array_unique($ids))->sortByDesc('price');
            case 'new':
                return Product::query()->findMany(array_unique($ids))->sortByDesc('created_at');
            case 'discount':
                return Product::query()->findMany(array_unique($ids))->sortByDesc('discount');
            default:
                return Product::query()->findMany(array_unique($ids))->sortBy('id');

        }
    }
}

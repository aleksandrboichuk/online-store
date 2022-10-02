<?php
namespace App\Services;


use App\Models\Product;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;

class ElasticSearchService
{

    /**
     * Search index
     *
     * @var string
     */
    private string $index_name = 'products';

    /**
     * Клиент эластика
     *
     * @var Client
     */
    private Client $elasticsearch;


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
     * @param string|null $sort
     * @return LengthAwarePaginator
     */
    public function search(string $seo_name, string $query = "", string|null $sort = "id"): LengthAwarePaginator
    {
        return $this->buildCollection(
          $this->searchOnElasticsearch($seo_name, $query, $this->getSortArray($sort))
        );
    }

    /**
     * Запрос в эластик для поиска по строке запроса
     *
     * @param string $seo_name
     * @param string $query
     * @param array $sort
     * @return array
     */
    private function searchOnElasticsearch(string $seo_name, string $query, array $sort): array
    {
        return $this->elasticsearch->search([
            'index' => $this->index_name,
            'type' => '_doc',
            'body' => [
               'size'=> 1000,
               'query' => [
                   'bool' => [
                       'must' => [
                           [
                               'match' => [
                                   'category_group_seo_name' => $seo_name
                               ]
                           ],
                           [
                               'multi_match' => [
                                   'fields' => ['name'],
                                   'query' => $query,
                                   'fuzziness' => 'AUTO'
                               ]
                           ]
                       ],

                   ],
               ],
                'sort' => $sort
            ],
        ]);
    }


    /**
     * Фильтрация
     *
     * @param array $must
     * @param array $arData
     * @param string|null $sort
     * @return LengthAwarePaginator
     */
    public function searchByFilters(
        array $must = [['match' => ['category_group_seo_name' => "women"]]],
        array $arData = [],
        string|null $sort = "id"
    ): LengthAwarePaginator
    {
        return $this->buildCollection(
            $this->searchByFiltersOnElasticsearch($must, $arData, $this->getSortArray($sort))
        );
    }

    /**
     * Запрос в эластик для фильтрации
     *
     * @param array $must
     * @param array $arrData
     * @param array $sort
     * @return array|callable
     */
    private function searchByFiltersOnElasticsearch(array $must, array $arrData, array $sort): callable|array
    {
        if(empty($arrData)){
            $arrData = [
                "bool" => [
                    "must" => [
                        "terms" => [
                            "active" => [1]
                        ]
                    ]
                ]
            ];
        }

        return $this->elasticsearch->search([
            'index' => $this->index_name,
            'type' => '_doc',
            'body' => [
                'size'=> 10000,
                'query' => [
                    'bool'=>[
                        'must' => $must,

                        'filter' => [
                            $arrData
                        ],
                    ],

                ],
                'sort' => $sort
            ],
        ]);
    }


    /**
     * Создание коллекции с результатами поиска
     *
     * @param array $items
     * @return LengthAwarePaginator
     */
    private function buildCollection(array $items): LengthAwarePaginator
    {
        $elements = $this->prepareElasticData(Arr::pluck($items['hits']['hits'], '_source'));

        return $this->paginate($elements, 8);
    }

    /**
     * Custom pagination
     *
     * @param $items
     * @param int $perPage
     * @param int|null $page
     * @param array $options
     * @return LengthAwarePaginator
     */
    private function paginate($items, int $perPage = 9, int $page = null, array $options = []): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make(json_decode(json_encode($items)));

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    /**
     * Returns sorting array for elasticsearch query
     *
     * @param string|null $sorting
     * @return \string[][][]
     */
    private function getSortArray(string|null $sorting): array
    {
        return match ($sorting) {
            'popularity' => [
                ['popularity' => ['order' => 'desc']]
            ],
            'price-asc' => [
                ['price' => ['order' => 'asc']]
            ],
            'price-desc' => [
                ['price' => ['order' => 'desc']]
            ],
            'new' => [
                ['created_at' => ['order' => 'desc']]
            ],
            'discount' => [
                ['discount' => ['order' => 'desc']]
            ],
            default => [
                ['id' => ['order' => 'desc']]
            ],
        };
    }

    /**
     * Returns prepared products data with right array keys
     *
     * @param array $data
     * @return array
     */
    private function prepareElasticData(array $data): array
    {
        $preparedData = [];

        foreach ($data as $item) {

            $item['categoryGroup'] = $item['category_group'];

            $item['subCategories'] = $item['sub_categories'];

            unset($item['category_group'], $item['sub_categories']);

            $preparedData[] = $item;
        }

        return $preparedData;
    }
}

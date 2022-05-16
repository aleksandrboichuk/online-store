<?php
/**
 * Created by PhpStorm.
 * User: boych
 * Date: 23.01.2022
 * Time: 14:36
 */

namespace App\Services;


use App\Models\Product;
use Elasticsearch\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use mysql_xdevapi\Collection;
use Nette\Utils\Paginator;

class ElasticSearch
{

    private $elasticsearch;
    private $productModel;

    public function __construct(Client $elasticsearch, Product $product)
    {
        $this->elasticsearch = $elasticsearch;
        $this->productModel = $product;
    }

    // ----------------------------------- simple search ----------------------------------

    public function search($seo_name, $query = "", $sort = "none"){
        return $this->buildCollection(
          $this->searchOnElasticsearch($seo_name, $query), $sort
        );
    }

    private function searchOnElasticsearch($seo_name, $query){
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


    // ----------------------------------- search request by filters ----------------------------------


    public function searchByFilters($must = [['match' => ['cg_seo_name' => "women"]]], $arData = [], $sort = "none"){
        return $this->buildCollection(
            $this->searchByFiltersOnElasticsearch($must, $arData), $sort
        );
    }

    private function searchByFiltersOnElasticsearch($must, $arData){
        if(empty($arData)){
            $arData = ["bool" => ["must" => ["terms" => ["active" => [1]]]]];
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
                            $arData
                        ]
                    ]
                ],
            ],
        ]);
    }



    // -------------------------------- prepare elastic results ----------------------------------

    private function buildCollection(array $items, $sort){
        $elements = Arr::pluck($items['hits']['hits'], '_source');
        $ids = [];
        foreach ($elements as $element) {
            array_push($ids, $element['id']);
        }

        // сортировка

        if($sort == 'popularity'){
            $products = Product::findMany(array_unique($ids))->sortByDesc('popularity');
        }elseif($sort == 'price-asc'){
            $products = Product::findMany(array_unique($ids))->sortBy('price');
        }elseif($sort == 'price-desc'){
            $products = Product::findMany(array_unique($ids))->sortByDesc('price');
        }elseif($sort == 'new'){
            $products = Product::findMany(array_unique($ids))->sortByDesc('created_at');
        }elseif($sort == 'discount'){
            $products = Product::findMany(array_unique($ids))->sortByDesc('discount');
        }else{
            $products = Product::findMany(array_unique($ids))->sortBy('id');
        }

        // пагинация

        return $this->paginate($products, 8);
    }

    private function paginate($items, $perPage = 9, $page = null, $options = [])
    {
        $page = $page ?: (\Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

}
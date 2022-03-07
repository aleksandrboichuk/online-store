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
use Illuminate\Support\Arr;

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

    public function search($seo_names, $query = ""){
        return $this->buildCollection(
          $this->searchOnElasticsearch($seo_names,$query)
        );
    }

    private function searchOnElasticsearch($seo_names, $query){
        //dd($query);
        return $this->elasticsearch->search([
            'index' => 'elastic_products',
            'type' => '_doc',
           'body' => [
               'size'=> 1000,
               'query' => [
                   'bool'=>[
                       'should'=>[
                           ['match' => ['name' => $query]],
                           ['match' => ['cg_seo_name' => $seo_names]]
                       ]
                   ]
               ]
           ],
        ]);
    }


    // ----------------------------------- search by filters ----------------------------------


    public function searchByFilters($seo_name, $colors = null){
        return $this->buildCollection(
            $this->searchByFiltersOnElasticsearch($seo_name, $colors)
        );
    }

    private function searchByFiltersOnElasticsearch($seo_name, $arData = []){
        return $this->elasticsearch->search([
            'index' => 'elastic_products',
            'size' => 6,
            'type' => '_doc',
            'body' => [
                'query' => [
                    'bool'=>[
                        'must'=>[
                            ['match' => ['cg_seo_name' => $seo_name]]
                        ],
                        'filter' => [
                            $arData
                        ]
                    ]
                ]
            ],
        ]);
    }



    // -------------------------------- prepare elastic results ----------------------------------

    private function buildCollection( array $items){
        $ids = Arr::pluck($items['hits']['hits'], '_id');
        return Product::findMany($ids)
            ->sortBy(function ($article) use ($ids) {
                return array_search($article->getKey(), $ids);
            });
    }
}
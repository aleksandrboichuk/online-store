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

    public function search($query = ""){
        return $this->buildCollection(
          $this->searchOnElasticsearch($query)
        );
    }

    private function searchOnElasticsearch($query = ""){
        //dd($query);
        return $this->elasticsearch->search([
           'index' => $this->productModel->getSearchIndex(),
           'type' => $this->productModel->getSearchType(),
           'body' => [
               'size'=>1000,
               'query' => [
                   'multi_match' => [
                       'fields' => ['name'],
                       'query' => $query,
                       'fuzziness' => 'AUTO'
                   ]
               ]
           ],
        ]);
    }

    private function buildCollection( array $items){
        $ids = Arr::pluck($items['hits']['hits'], '_id');
        return Product::findMany($ids)
            ->sortBy(function ($article) use ($ids) {
                return array_search($article->getKey(), $ids);
            });
    }
}
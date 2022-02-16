<?php
/**
 * Created by PhpStorm.
 * User: boych
 * Date: 22.01.2022
 * Time: 20:06
 */

namespace App\Observers;

use Elasticsearch\Client;

class ElasticSearchObserver
{
//
//    private $elasticsearch;
//
//    public function __construct(Client $elasticsearch )
//    {
//        $this->elasticsearch = $elasticsearch;
//    }
//
//    public function saved($model){
//        $this->elasticsearch->index([
//            'index' => $model->getSearchIndex(),
//            'type' => $model->getSearchType(),
//            'id' => $model->getKey(),
//            'body' => $model->toSearchArray(),
//        ]);
//    }
//
//    public function delete($model){
//        $this->elasticsearch->delete([
//            'index' => $model->getSearchIndex(),
//            'type' => $model->getSearchType(),
//            'id' => $model->getKey(),
//        ]);
//    }
}
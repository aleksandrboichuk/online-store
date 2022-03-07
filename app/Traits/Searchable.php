<?php
/**
 * Created by PhpStorm.
 * User: boych
 * Date: 22.01.2022
 * Time: 20:07
 */

namespace App\Traits;

use App\Observers\ElasticSearchObserver;

trait Searchable
{
//    public static function bootSearchable(){
//       static::observe(ElasticSearchObserver::class);
//    }

    public function getSearchIndex(){
        return "elastic_products";
    }

    public function getSearchType(){
        return '_doc';
    }

    public function  toSearchArray(){
        return [
          'name' => $this->name,
        ];
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: boych
 * Date: 22.01.2022
 * Time: 20:06
 */

namespace App\Observers;

use App\Models\Product;
use Elasticsearch\Client;
use Illuminate\Support\Facades\Artisan;

class ElasticSearchObserver
{

    private $elasticsearch;

    public function __construct(Client $elasticsearch )
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function created(Product $product)
    {
        Artisan::command('search:reindex', function () {
            dd("Indexing...!");
        });
    }

    public function saved(Product $product){
        Artisan::command('search:reindex', function () {
            dd("Indexing...!");
        });
    }

    public function delete(Product $product){
        Artisan::command('search:reindex', function () {
            dd("Indexing...!");
        });
    }
}
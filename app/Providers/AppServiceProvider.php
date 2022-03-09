<?php

namespace App\Providers;
use App\Models\Product;
use App\Observers\ElasticSearchObserver;
use App\Services\ElasticSearch;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use App\Models\Category;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       $this->app->bind(Client::class, function (){
          return ClientBuilder::create()
          ->setHosts(config('services.search.hosts'))
          ->build();
       });


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Product::observe(ElasticSearchObserver::class);
    }
}

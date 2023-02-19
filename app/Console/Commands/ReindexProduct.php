<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use function PHPUnit\Framework\returnArgument;

class ReindexProduct extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex';

    /**
     * Elasticsearch client
     *
     * @var Client
     */
    private Client $elasticsearch;

    /**
     * Search index
     *
     * @var string
     */
    private string $index_name = 'products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexing all products to elasticsearch';

    /**
     * Products for indexing
     *
     * @var array|Collection
     */
    protected array|Collection $products;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $elasticsearch)
    {
        parent::__construct();

        $this->elasticsearch = $elasticsearch;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Indexing...');

        if($this->elasticsearch->indices()->exists(['index' => $this->index_name])) {
            $this->info('Deleting index...');

            try{
                $this->elasticsearch->indices()->delete(['index' => $this->index_name]);
            }catch (\Exception $e)
            {
                $this->warn('[Deleting index] ' . $e->getMessage());
            }
        }
            //creating index
        try{
            $this->elasticsearch->indices()->create($this->indexParameters());
            $this->info('Index has been created');

        }catch(\Exception $e){

            $this->warn('[Creating index] ' . $e->getMessage());
            exit;
        }

        $this->prepareData();

        // to Elastic
        $this->info('Sending Data...');
        $this->toElastic();

        $this->info('Done!');
    }

    private function toElastic()
    {
        foreach ($this->products as $item) {
            $params = [
                'index' => $this->index_name,
                'type' => '_doc',
                'body' => $item->toArray()
            ];

            try {
                $this->elasticsearch->index($params);
            } catch (\Exception $e) {
                $this->warn('[Sending] ' . $e->getMessage());
            }
        }
    }

    /**
     * Preparing products for indexing
     *
     * @return void
     */
    private function prepareData(): void
    {
        $products = Product::query()
            ->where('active', 1)
            ->with(['colors', 'seasons', 'category', 'categoryGroup', 'materials', 'sizes', 'brands', 'images'])
            ->get();

        foreach ($products as $product) {

            $product->in_stock = $product->in_stock == 1;

            $product->created_at = Carbon::createFromFormat('Y-m-d H:i:s',  $product->created_at);

            $product->category_group = $product->categoryGroup;

            $product->category = $product->category?->parent;

            $product->subcategory = $product->category;
        }

        $this->products = $products;
    }

    /**
     * Returns parameters for indexing
     *
     * @return array
     */
    private function indexParameters(): array
    {
       return [
                'index' => $this->index_name,
                'body' =>[
                   'settings'=>[
                       'analysis'=> [
                           'filter'=>[
                               "russian_stop" =>[
                                   "type"=>"stop",
                                   "stopwords"=>"_russian_",
                               ],
                               'shingle' =>[
                                   'type' => 'shingle'
                               ],
                               'length_filter' =>[
                                   'type' => 'length',
                                   "min" => 3
                               ],
                               "russian_stemmer" =>[
                                   "type"=>"stemmer",
                                   "language"=>"russian",
                               ],
                           ],
                           'analyzer' => [
                               'autocomplete' => [
                                   'tokenizer' => 'custom_tokenizer'
                               ]
                           ],
                           'tokenizer' => [
                               'custom_tokenizer'=> [
                                   'type' => 'ngram',
                                   'min_gram' => 1,
                                   'max_gram' => 5,
                                   'token_chars' => [
                                       'letter',
                                       'digit',
                                       'symbol',
                                       'punctuation',
                                   ]
                               ]
                           ]
                       ],
                       'max_ngram_diff' => 50,
                   ],
                   'mappings' => [
                       'properties' =>[
                           'id' =>[
                               'type' => 'integer',
                           ],
                           'name' => [
                               'type' => 'text',
                               'fields' => [
                                   'raw' => [
                                       'type' => 'keyword',
                                   ],
                               ],
                           ],
                           'seo_name' =>[
                               'type' => 'text',
                           ],
                           'preview_img_url' =>[
                               'type' => 'text',
                           ],
                           'description' =>[
                               'type' => 'text',
                               'fields' => [
                                   'raw' => [
                                       'type' => 'keyword',
                                   ],
                               ],
                           ],
                           'price' =>[
                               'type' => 'integer',
                           ],
                           'discount' =>[
                               'type' => 'integer',
                           ],
                           'count' =>[
                               'type' => 'integer',
                           ],
                           'in_stock' =>[
                               'type' => 'boolean',
                           ],
                           'rating' =>[
                               'type' => 'float',
                           ],
                           'popularity' =>[
                               'type' => 'integer',
                           ],
                           'banner_id' =>[
                               'type' => 'integer'
                           ],
                           'url' =>[
                               'type' => 'text'
                           ],
                           'category_id' =>[
                               'type' => 'integer'
                           ],
                           'created_at' =>[
                               'type' => 'date',
                               'format' => 'strict_date_optional_time'
                           ],
                           'category_group' => [
                               'type' => 'object',
                           ],
                           'category' => [
                               'type' => 'object',
                           ],
                           'subcategory' => [
                               'type' => 'object',
                           ],
                           'brands' => [
                               'type' => 'object',
                               'properties' => [
                                   'seo_name' =>[
                                       'type' => 'text',
                                   ]
                                ],
                           ],
                           'colors' => [
                               'type' => 'object',
                           ],
                           'seasons' => [
                               'type' => 'object',
                           ],
                           'sizes' => [
                               'type' => 'object',
                           ],
                           'materials' => [
                               'type' => 'object',
                           ]
                       ]
                   ]
               ]
        ];

    }

}

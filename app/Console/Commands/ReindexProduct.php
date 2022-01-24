<?php

namespace App\Console\Commands;

use App\Models\Product;
use Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;
use Elasticsearch\Client;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\returnArgument;

class ReindexProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex';
    protected $description = 'indexes all products';
    private $elasticsearch;
    private $product;

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $elasticsearch, Product $product)
    {
        parent::__construct();

        $this->elasticsearch = $elasticsearch;
        $this->product = $product;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Indexing...');
        try {
            $this->elasticsearch->indices()->delete(['index' => $this->product->getSearchIndex()]);
        } catch (\Exception $e) {
        }
        $this->elasticsearch->indices()->create($this->createIndex($this->product));
        foreach (Product::cursor() as $article) {
            $this->elasticsearch->index([
                'index' => $article->getSearchIndex(),
                'type' => $article->getSearchType(),
                'id' => $article->getKey(),
                'body' => $article->toSearchArray(),
            ]);

            $this->output->write('.');
        }
        $this->info('\nDone');
    }


    private function createIndex($product){
       return [
               'index' => $product->getSearchIndex(),
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
                               "english_stemmer" =>[
                                   "type"=>"stemmer",
                                   "language"=>"english",
                               ],
                           ],
                           'analyzer' => [
                               'name'=> [
                                   'type' => 'custom',
                                   'tokenizer' =>'standard',
                                   'filter' => [
                                       'lowercase',
                                       'length_filter',
                                       'trim',
                                       'russian_stemmer',
                                       'english_stemmer',
                                       'russian_stop',

                                   ]
                               ]
                           ]
                       ]
                   ],
                   'mappings' => [
                       'properties' =>[
                           'name' =>[
                               'type' => 'text',
                               'analyzer' => 'name'
                           ],
                       ]
                   ]
               ]
        ];

    }

}

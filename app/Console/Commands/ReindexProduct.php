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
    private $items;

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
    public function __construct(Client $elasticsearch)
    {
        parent::__construct();

        $this->elasticsearch = $elasticsearch;
        $this->items = DB::table('elastic_products')->orderBy('id')->get();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Indexing...');
        if($this->elasticsearch->indices()->exists(['index' => 'elastic_products'])) {
            try {
                $this->elasticsearch->indices()->delete(['index' => 'elastic_products']);
                $this->info('Index has been deleted');
            } catch (\Exception $e) {
                print_r($e->getMessage() . PHP_EOL);
            }

            //creating index
            try{
                $this->elasticsearch->indices()->create($this->params());
                $this->info('Index has been created');
            }catch(\Exception $e){
                print_r($e->getMessage() . PHP_EOL);
            }
        }else{
            try{
                $this->elasticsearch->indices()->create($this->params());
                $this->info('Index has been created');
            }catch(\Exception $e){
                print_r($e->getMessage() . PHP_EOL);
            }
        }

        // to Elastic
        foreach ($this->items as $k => $l) {
            $arEntryParams[$k] = $l;
        }
        foreach ($arEntryParams as $key => $item) {
            $params = [
                'index' => 'elastic_products',
                'type' => '_doc',
                'id' => $key + 1,
                'body' => $item
            ];

            try {
                $this->elasticsearch->index($params);

            } catch (\Exception $e) {
                print_r($e->getMessage() . PHP_EOL);
                exit;
            }
        }

        $this->info('\nDone');
    }


    private function params(){
       return [
               'index' => 'elastic_products',
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
                               'rebuilt_russian'=> [
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
                           'id' =>[
                               'type' => 'integer',
                           ],
                           'name' => [
                               'type' => 'text',
                               'analyzer' => 'rebuilt_russian'
                           ],
                           'seo_name' =>[
                               'type' => 'text',
                           ],
                           'preview_img_url' =>[
                               'type' => 'text',
                           ],
                           'description' =>[
                               'type' => 'text',
                               'analyzer' => 'rebuilt_russian'
                           ],
                           'banner_id' =>[
                               'type' => 'integer'
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
                           'created_at' =>[
                               'type' => 'date',
                               'format' => 'yyyy-MM-dd HH:mm:ss'
                           ],
                           'product_category_group' =>[
                               'type' => 'integer',
                           ],
                           'product_category' =>[
                               'type' => 'integer',
                           ],
                           'product_category_sub_' =>[
                               'type' => 'integer',
                           ],
                           'product_color' =>[
                               'type' => 'integer',
                           ],
                           'product_season' =>[
                               'type' => 'integer',
                           ],
                           'product_brand' =>[
                               'type' => 'integer',
                           ],
                           'cg_name' =>[
                               'type' => 'text',
                           ],
                           'cg_seo_name' =>[
                               'type' => 'text',
                           ],
                           'c_title' =>[
                               'type' => 'text',
                           ],
                           'c_name' =>[
                               'type' => 'text',
                           ],
                           'c_seo_name' =>[
                               'type' => 'text',
                           ],
                           'sc_title' =>[
                               'type' => 'text',
                           ],
                           'sc_name' =>[
                               'type' => 'text',
                           ],
                           'sc_seo_name' =>[
                               'type' => 'text',
                           ],
                           'pc_id' =>[
                               'type' => 'integer',
                           ],
                           'pc_name' =>[
                               'type' => 'text',
                           ],
                           'pc_seo_name' =>[
                               'type' => 'text',
                           ],
                           'ps_id' =>[
                               'type' => 'integer',
                           ],
                           'ps_name' =>[
                               'type' => 'text',
                           ],
                           'ps_seo_name' =>[
                               'type' => 'text',
                           ],
                           'pb_id' =>[
                               'type' => 'integer',
                           ],
                           'pb_name' =>[
                               'type' => 'text',
                           ],
                           'pb_seo_name' =>[
                               'type' => 'text',
                           ],
                           'pm_id' =>[
                               'type' => 'integer',
                           ],
                           'pm_name' =>[
                               'type' => 'text',
                           ],
                           'pm_seo_name' =>[
                               'type' => 'text',
                           ],
                           'psize_id' =>[
                               'type' => 'integer',
                           ],
                           'psize_name' =>[
                               'type' => 'text',
                           ],
                           'psize_seo_name' => [
                               'type' => 'text',
                           ],

                       ]
                   ]
               ]
        ];

    }

}

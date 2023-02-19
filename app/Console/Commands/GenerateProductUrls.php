<?php

namespace App\Console\Commands;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class GenerateProductUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:generate-urls';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate all product urls by rule';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $products = Product::all();

        foreach ($products as $product) {
            if($product->updateUrl()){
                $this->info("$product->id product URL updated");
            }else{
                $this->error("$product->id product URL not updated!");
            }
        }

        return 0;
    }
}

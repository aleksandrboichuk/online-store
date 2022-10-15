<?php

namespace App\Console\Commands;

use App\Models\Cart;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class DeleteOldCarts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart:delete-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deleting old carts, which was created using session token';

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
        $carts = Cart::query()
            ->where('user_id', null)
            ->where('created_at', '<', Carbon::now('Europe/Kiev')->subDay())
            ->get();

        foreach ($carts as $cart){
            $cart->delete();
        }

        return 0;
    }
}

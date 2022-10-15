<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_product', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cart_id')->unsigned();
            $table->foreign('cart_id')
                ->references('id')
                ->on('carts')
                ->onDelete('cascade');
            $table->bigInteger('product_id')->unsigned();
                $table->foreign('product_id')
                    ->references('id')
                    ->on('products')
                    ->onDelete('cascade');
            $table->integer('count');
            $table->integer('size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('cart_product')
            && Schema::hasColumns('cart_product', ['cart_id', 'product_id'])
        ){
            Schema::table('cart_product', function (Blueprint $table) {
                $table->dropForeign('cart_product_cart_id_foreign');
                $table->dropForeign('cart_product_product_id_foreign');
            });
        }
        Schema::dropIfExists('cart_product');
    }
}

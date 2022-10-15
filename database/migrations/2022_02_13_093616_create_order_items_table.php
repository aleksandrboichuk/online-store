<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->string('name', 100);
            $table->integer('price')->unsigned();
            $table->integer('count')->default(1);
            $table->integer('total_cost')->unsigned();

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->cascadeOnDelete();
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->nullOnDelete();

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
        if(Schema::hasTable('order_items')
            && Schema::hasColumns('order_items', ['order_id','product_id'])
        ){
            Schema::table('order_items', function (Blueprint $table) {
                $table->dropForeign('order_items_product_id_foreign');
                $table->dropForeign('order_items_order_id_foreign');
            });
        }
        Schema::dropIfExists('order_items');
    }
}

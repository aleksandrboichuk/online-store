<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductBrandIdToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            if(!Schema::hasColumn('products','product_brand_id')) {
                $table->bigInteger('product_brand_id')->unsigned();
                $table->foreign('product_brand_id')
                    ->references('id')
                    ->on('brands')
                    ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('products')
            && Schema::hasColumns('products', ['product_brand_id'])
        ){
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign('products_product_brand_id_foreign');

                $table->dropColumn('product_brand_id');
            });
        }
    }
}

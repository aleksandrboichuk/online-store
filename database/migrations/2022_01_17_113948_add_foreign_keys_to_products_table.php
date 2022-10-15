<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('product_color_id')
                ->references('id')
                ->on('colors')
                ->onDelete('cascade');
            $table->foreign('product_season_id')
                ->references('id')
                ->on('seasons')
                ->onDelete('cascade');
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
            && Schema::hasColumns('products', ['product_season_id', 'product_color_id'])
        ){
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign('products_product_color_id_foreign');
                $table->dropForeign('products_product_season_id_foreign');
            });
        }
    }
}

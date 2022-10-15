<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('category_group_id')->unsigned();
            $table->foreign('category_group_id')
                ->references('id')
                ->on('category_groups')
                ->onDelete('cascade');
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            $table->bigInteger('category_sub_id')->unsigned();
            $table->foreign('category_sub_id')
                ->references('id')
                ->on('sub_categories')
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
            && Schema::hasColumns('products', ['category_group_id', 'category_id', 'category_sub_id'])
        ){

           Schema::table('products', function (Blueprint $table) {
               $table->dropForeign('products_category_group_id_foreign');
               $table->dropForeign('products_category_id_foreign');
               $table->dropForeign('products_category_sub_id_foreign');

               $table->dropColumn('category_group_id');
               $table->dropColumn('category_id');
               $table->dropColumn('category_sub_id');
           });
       }
    }
}

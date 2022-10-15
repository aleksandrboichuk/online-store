<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBannerIdToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('banner_id')->unsigned()->nullable()->after('active');
            $table->foreign('banner_id')
                ->references('id')
                ->on('banners')
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
            && Schema::hasColumns('products', ['banner_id'])
        ){
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign('products_banner_id_foreign');

                $table->dropColumn('banner_id');
            });
        }
    }
}

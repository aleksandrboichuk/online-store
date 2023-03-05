<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCharacteristicsFieldsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('products','color_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->bigInteger('color_id')->unsigned();
                $table->bigInteger('season_id')->unsigned();
             });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('products')
            && Schema::hasColumns('products', ['season_id', 'color_id'])
        ){
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('season_id');
                $table->dropColumn('color_id');
            });
        }
    }
}

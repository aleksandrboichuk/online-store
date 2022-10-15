<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMinTotalFieldToPromocodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promocodes', function (Blueprint $table) {
            $table->integer('discount')->after('description')->nullable();
            $table->integer('min_cart_total')->after('discount')->nullable();
            $table->integer('min_cart_products')->after('min_cart_total')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('promocodes')
            && Schema::hasColumns('promocodes', ['discount', 'min_cart_total', 'min_cart_products'])
        ){
            Schema::table('promocodes', function (Blueprint $table) {
                $table->dropColumn('discount');
                $table->dropColumn('min_cart_total');
                $table->dropColumn('min_cart_products');
            });
        }
    }
}

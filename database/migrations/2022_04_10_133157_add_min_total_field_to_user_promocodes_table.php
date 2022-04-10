<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMinTotalFieldToUserPromocodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_promocodes', function (Blueprint $table) {
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
        Schema::table('user_promocodes', function (Blueprint $table) {
            //
        });
    }
}

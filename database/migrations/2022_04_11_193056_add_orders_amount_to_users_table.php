<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrdersAmountToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('orders_amount')->default(0)->after('phone');
            $table->integer('orders_sum')->default(0)->after('orders_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('users')
            && Schema::hasColumns('users', ['orders_amount', 'orders_sum'])
        ){
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('orders_amount');
                $table->dropColumn('orders_sum');
            });
        }
    }
}

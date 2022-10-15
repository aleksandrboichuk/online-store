<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
           $table->bigInteger('status')->unsigned()->nullable()->after('total_cost');
           $table->foreign('status')
               ->references('id')
               ->on('status_lists')
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
        if(Schema::hasTable('orders')
            && Schema::hasColumns('orders', ['status'])
        ){
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign('orders_status_foreign');

                $table->dropColumn('status');
            });
        }
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryGroupIdToBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->bigInteger('category_group_id')->unsigned()->nullable()->after('active');
            $table->foreign('category_group_id')
                ->references('id')
                ->on('category_groups')
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
        if(Schema::hasTable('banners')
            && Schema::hasColumns('banners', ['category_group_id'])
        ){
            Schema::table('banners', function (Blueprint $table) {
                $table->dropForeign('banners_category_group_id_foreign');

                $table->dropColumn('category_group_id');
            });
        }
    }
}

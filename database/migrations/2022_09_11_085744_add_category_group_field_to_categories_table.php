<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryGroupFieldToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->bigInteger('category_group')->after('seo_name')->unsigned()->nullable();
            $table->foreign('category_group')
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
        if(Schema::hasTable('categories')
            && Schema::hasColumns('categories', ['category_group'])
        ){
            Schema::table('categories', function (Blueprint $table) {
                $table->dropForeign('categories_category_group_foreign');

                $table->dropColumn('category_group');
            });
        }
    }
}

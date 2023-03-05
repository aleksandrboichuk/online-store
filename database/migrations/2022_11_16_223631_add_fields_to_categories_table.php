<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('categories') && !Schema::hasColumn('categories', 'level')){
            Schema::table('categories', function (Blueprint $table) {
                $table->bigInteger('parent_id')->unsigned()->nullable()->after('seo_name');
                $table->integer('level')->nullable()->after('parent_id');

                $table->foreign('parent_id')
                    ->references('id')
                    ->on('categories')
                    ->cascadeOnUpdate();
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
        if(Schema::hasTable('categories') && Schema::hasColumn('categories', 'level')){
            Schema::table('categories', function (Blueprint $table) {
                $table->dropForeign('categories_parent_id_foreign');
                $table->dropColumn('level');
                $table->dropColumn('parent_id');
            });
        }
    }
};

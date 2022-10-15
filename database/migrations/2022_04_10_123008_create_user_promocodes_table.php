<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPromocodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_promocodes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('promocode_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('promocode_id')
                ->references('id')
                ->on('promocodes')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('user_promocodes')
            && Schema::hasColumns('user_promocodes', ['user_id', 'promocode_id'])
        ){
            Schema::table('user_promocodes', function (Blueprint $table) {
                $table->dropForeign('user_promocodes_promocode_id_foreign');
                $table->dropForeign('user_promocodes_user_id_foreign');
            });
        }

        Schema::dropIfExists('user_promocodes');
    }
}

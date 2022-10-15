<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_reviews', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->integer('grade')->default(5);
            $table->string('review', 100);
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
        if(Schema::hasTable('user_reviews')
            && Schema::hasColumns('user_reviews', ['product_id', 'user_id'])
        ){
            Schema::table('user_reviews', function (Blueprint $table) {
                $table->dropForeign('user_reviews_product_id_foreign');
                $table->dropForeign('user_reviews_user_id_foreign');
            });
        }
        Schema::dropIfExists('user_reviews');
    }
}

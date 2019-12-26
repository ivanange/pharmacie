<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('category_id')
            ->references('id')->on('categories');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->foreign('product_id')
            ->references('id')->on('products');
            $table->foreign('command_id')
            ->references('id')->on('commands');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['command_id']);
        });
    }
}

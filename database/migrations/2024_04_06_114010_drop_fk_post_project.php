<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropFkPostProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) { 
            $table->foreign('category_id')->references('id')->on('blog_categories');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->foreign('service_id')->references('id')->on('services');
        });
    }
}

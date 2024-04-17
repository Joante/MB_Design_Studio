<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteFkids extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['category_id']);
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['service_id']);
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
            $table->unsignedBigInteger('category_id');
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('service_id');
        });
    }
}

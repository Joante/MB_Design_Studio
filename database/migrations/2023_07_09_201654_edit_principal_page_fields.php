<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditPrincipalPageFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->boolean('principal_page')->nullable()->change();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->boolean('principal_page')->nullable()->change();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('principal_page')->nullable()->change();
        });

        Schema::table('exhibitions', function (Blueprint $table) {
            $table->boolean('principal_page')->nullable()->change();
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->unsignedInteger('phone')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->boolean('principal_page')->change();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->boolean('principal_page')->change();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('principal_page')->change();
        });

        Schema::table('exhibitions', function (Blueprint $table) {
            $table->boolean('principal_page')->change();
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->unsignedInteger('phone')->change();
        });
    }
}

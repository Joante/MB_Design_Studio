<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditInformationTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('information', function (Blueprint $table) {
            $table->json('about')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('information', function (Blueprint $table) {
            $table->text('about')->change();
        });
    }
}

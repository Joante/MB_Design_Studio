<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHierarchyImages extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->integer('hierarchy');
            $table->text('description')->nullable()->change();
            $table->unique(['hierarchy', 'model_type', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (Schema::hasColumn('images', 'hierarchy')) {
            Schema::table('images', function (Blueprint $table) {
                $table->dropUnique(['hierarchy', 'model_type', 'model_id']);
                $table->dropColumn('hierarchy');
                $table->string('description')->nullable()->change();
            });
        }
    }
}

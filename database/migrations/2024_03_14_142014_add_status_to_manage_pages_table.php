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
        Schema::table('manage_pages', function (Blueprint $table) {
            $table->tinyInteger('status')->after('disclaimers')->default('1')->comment('1: live ,2 :preview');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manage_pages', function (Blueprint $table) {
            //
        });
    }
};

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
        Schema::create('artist_featureds', function (Blueprint $table) {
            $table->id();
            $table->integer('artist_id')->index();
            $table->string('page_title');
            $table->string('page_slug');
            $table->string('title');
            $table->text('video_url')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('status')->default('1')->comment('1: Active ,2 :Inactive');
            $table->integer('is_preview')->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artist_featureds');
    }
};

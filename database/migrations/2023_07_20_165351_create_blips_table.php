<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blips', function (Blueprint $table) {
            $table->id();
            $table->string('buid');
            $table->unsignedBigInteger('blip_author');
            $table->longText('blip_content');
            $table->boolean('blip_privacy');
            $table->boolean('blip_deleted');
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
        Schema::dropIfExists('blips');
    }
}

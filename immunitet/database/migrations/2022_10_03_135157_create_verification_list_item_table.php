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
        Schema::create('site_verification_list_item', function (Blueprint $table) {
            $table->id();
            $table->string('value', 64);
            $table->unsignedBigInteger('site_list_id');
            $table->foreign('site_list_id')->references('id')->on('site_verification')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('site_verification_list_item');
    }
};

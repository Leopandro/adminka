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
    public function up(): void
    {
        Schema::create('country', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 16);
            $table->timestamps();
        });
        Schema::create('company', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 32);
            $table->integer('inn');
            $table->integer('postcode');
            $table->foreignId('country_id')
                ->references('id')
                ->on('country')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->string('city', 28);
            $table->text('address')->nullable();
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
        Schema::dropIfExists('company');
        Schema::dropIfExists('country');
    }
};

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
        Schema::table('email_notification', function (Blueprint $table) {
            $table->dropColumn('email_list');
        });
        Schema::table('email_notification', function (Blueprint $table) {
            $table->string('list_item', 64)->nullable();
        });
        Schema::table('site_verification', function (Blueprint $table) {
            $table->dropColumn('verification_list');
        });
        Schema::table('site_verification', function (Blueprint $table) {
            $table->string('list_item', 64)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_notification', function (Blueprint $table) {
            $table->dropColumn('list_item');
        });
        Schema::table('email_notification', function (Blueprint $table) {
            $table->text('email_list');
        });
        Schema::table('site_verification', function (Blueprint $table) {
            $table->dropColumn('list_item');
        });
        Schema::table('site_verification', function (Blueprint $table) {
            $table->text('verification_list');
        });
    }
};

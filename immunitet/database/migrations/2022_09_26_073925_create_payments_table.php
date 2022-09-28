<?php

use App\Enum\PaymentStatus;
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
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->uuid('payment_uuid');
            $table->integer('sum');
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->string('payment_cryptogram', 512)->nullable();
            $table->string('currency');
            $table->string('status')->default(PaymentStatus::CREATED);
            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
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
        Schema::dropIfExists('payment');
    }
};

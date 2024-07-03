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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('transactionID')->nullable();
            $table->string('productName')->nullable();
            $table->string('productImage')->nullable();
            $table->string('unitPrice')->nullable();
            $table->string('totalPrice')->nullable();
            $table->string('productQuantity')->nullable();
            $table->string('paymentStatus')->nullable();
            $table->string('deliveryStatus')->nullable();
            $table->string('status')->nullable();
            $table->string('status1')->nullable();
            $table->string('status2')->nullable();



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
        Schema::dropIfExists('payments');
    }
};

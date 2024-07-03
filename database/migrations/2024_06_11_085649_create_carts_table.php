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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId')->nullable();
            // $table->foreign('userId')->references('id')->on('users')->onDelete('set NULL');//DELETE AND SET USERID AS NULL
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');//DELETE EVERYTHING CONCERNING THE USER
            $table->unsignedBigInteger('productId')->nullable();
            $table->foreign('productId')->references('id')->on('products')->onDelete('set NULL');

            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('productName')->nullable();
            $table->string('productImage')->nullable();
            $table->string('unitPrice')->nullable();
            $table->string('totalPrice')->nullable();
            $table->string('productQuantity')->nullable();
            $table->string('status')->nullable();
            $table->string('status1')->nullable();
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
        Schema::dropIfExists('carts');
    }
};

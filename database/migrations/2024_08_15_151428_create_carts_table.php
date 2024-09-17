<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->on('products')->references('id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->on('customers')->references('id');
            $table->unsignedBigInteger('guest_id')->nullable();
            $table->foreign('guest_id')->on('guests')->references('id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->on('orders')->references('id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};

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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guest_id')->nullable();
            $table->foreign('guest_id')->on('guests')->references('id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->on('customers')->references('id');
            $table->unsignedBigInteger('customer_address_id')->nullable();
            $table->foreign('customer_address_id')->on('customer_addresses')->references('id');
            $table->unsignedBigInteger('order_status_id');
            $table->foreign('order_status_id')->on('order_statuses')->references('id');
            $table->double('subtotal')->nullable();
            $table->double('tax')->nullable();
            $table->double('shipping')->nullable();
            $table->double('total')->nullable();
            $table->text('transaction_reference')->nullable();
            $table->text('response_message')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

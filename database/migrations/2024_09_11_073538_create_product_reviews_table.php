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
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('stars')->default(0);
            $table->string('message')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->on('customers')->references('id');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->on('products')->references('id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};

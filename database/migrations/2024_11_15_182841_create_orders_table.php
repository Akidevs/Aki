<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('renter_id'); // Foreign key to users table
            $table->unsignedBigInteger('product_id'); // Foreign key to products table
            $table->string('status')->default('pending'); // pending, confirmed, completed, canceled
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('proof_path')->nullable(); // Path to proof of transaction
            $table->timestamps();

            $table->foreign('renter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}
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
            $table->foreignId('user_id')->constrained();
            $table->foreignId('table_id')->constrained()->nullable();
            $table->foreignId('restaurant_id')->constrained();
            $table->foreignId('booking_id')->constrained()->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->string('status', 20)->default('pending'); // pending, preparing, ready, served, completed, cancelled
            $table->string('payment_status', 20)->default('pending'); // pending, paid, refunded
            $table->string('payment_method', 30)->nullable(); // cash, card, digital
            $table->text('special_instructions')->nullable();
            $table->datetime('created_at_order')->nullable();
            $table->datetime('estimated_ready_time')->nullable();
            $table->timestamps();
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

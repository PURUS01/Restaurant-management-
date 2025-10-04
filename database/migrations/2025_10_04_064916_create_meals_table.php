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
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->string('name', 60);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('category', 30); // appetizer, main_course, dessert, beverage
            $table->string('image_url', 60)->nullable();
            $table->boolean('is_available')->default(true);
            $table->integer('preparation_time')->nullable(); // in minutes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};

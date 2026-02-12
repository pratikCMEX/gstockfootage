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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->enum('duration_type', ['month', 'quarter', 'year'])->nullable();
            $table->integer('duration_value')->default(1);
            $table->integer('total_clips')->nullable();
            $table->decimal('price_per_clip', 10, 2)->nullable();
            $table->integer('discount_percentage')->nullable();
              $table->enum('is_active', ['0', '1'])->default('1')->comment('0=>inactive,1=>active');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};

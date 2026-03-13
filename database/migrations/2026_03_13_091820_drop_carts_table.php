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
       Schema::dropIfExists('carts');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('carts', function ($table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->integer('qty')->default(1);
            $table->timestamps();
        });
    }
};

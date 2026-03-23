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
        Schema::create('affiliates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_user_id')
                  ->constrained('affiliate_users')
                  ->onDelete('cascade');
            $table->string('referral_code')->unique();
            $table->enum('commission_type', ['fixed', 'percentage'])->default('fixed');
            $table->decimal('commission_value', 10, 2)->default(0.00);
            $table->decimal('total_earnings', 10, 2)->default(0.00);
            $table->integer('total_referrals')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliates');
    }
};

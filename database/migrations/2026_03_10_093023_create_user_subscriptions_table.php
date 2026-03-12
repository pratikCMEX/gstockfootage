<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subscription_plan_id')->constrained();

            // subscription info
            $table->date('start_date');
            $table->date('end_date');

            $table->integer('total_clips')->nullable();
            $table->integer('used_clips')->default(0);
            $table->integer('remaining_clips')->nullable();

            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');

            // payment info
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('USD');
            $table->string('payment_gateway')->nullable();
            $table->string('transaction_id')->nullable();
            $table->enum('payment_status', ['pending', 'success', 'failed']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};

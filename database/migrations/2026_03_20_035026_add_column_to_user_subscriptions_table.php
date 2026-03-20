<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_subscriptions', function (Blueprint $table) {
            // if ($table->getColumnListing()->contains('name', 'status')) {
            $table->dropColumn('status');
            // }

            $table->enum('status', ['active', 'expired', 'inactive', 'cancelled', 'payment_failed', 'past_due'])
                ->after('stripe_subscription_id')
                ->nullable(false)
                ->default('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_subscriptions', function (Blueprint $table) {
            //
        });
    }
};

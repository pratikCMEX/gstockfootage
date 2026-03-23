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
        Schema::table('affiliates', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            //  Add new affiliate_user_id
            $table->foreignId('affiliate_user_id')
                  ->after('id')
                  ->constrained('affiliate_users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('affiliates', function (Blueprint $table) {
           $table->dropForeign(['affiliate_user_id']);
            $table->dropColumn('affiliate_user_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        });
    }
};

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
        Schema::table('license_masters', function (Blueprint $table) {
            $table->foreignId('product_quality_id')->nullable()->after('id')->constrained('product_qualities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('license_masters', function (Blueprint $table) {
            $table->dropForeign(['product_quality_id']);
            $table->dropColumn('product_quality_id');
        });
    }
};

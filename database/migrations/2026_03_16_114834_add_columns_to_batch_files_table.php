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
        Schema::table('batch_files', function (Blueprint $table) {

            // --- Orientation ---
            // Stored as an enum since values are fixed and known.
            $table->enum('orientation', [
                'landscape',
                'portrait',
                'square',
                'vertical',
            ])->nullable()->default(null)->after('height');

            // --- Camera Movement ---
            // Stored as an enum for the same reason.
            $table->enum('camera_movement', [
                'static',
                'pan',
                'tilt',
                'tracking',
                'aerial',
                'zoom',
            ])->nullable()->default(null)->after('orientation');

            // --- License Type ---
            // Stored as an enum. Extend values here if more types are added later.
            $table->enum('license_type', [
                'rights_managed',
                'royalty_free',
                'editorial',
                'creative_commons',
            ])->nullable()->default(null)->after('camera_movement');

            // --- With People (Content filter) ---
            // Simple boolean flag; false = no people, true = with people.
            $table->json('content_filters')
                ->nullable()
                ->default(null)
                ->after('license_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batch_files', function (Blueprint $table) {
            $table->dropColumn([
                'orientation',
                'camera_movement',
                'license_type',
                'content_filters',
            ]);
        });
    }
};

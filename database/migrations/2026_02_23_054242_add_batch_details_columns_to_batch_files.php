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
            $table->string('title')->nullable()->after('duration');
            $table->text('description')->nullable()->after('title');
            $table->date('date_created')->nullable()->after('description');
            $table->string('country')->nullable()->after('date_created');
            $table->text('keywords')->nullable()->after('country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batch_files', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->date('date_created')->nullable();
            $table->string('country')->nullable();
            $table->text('keywords')->nullable();
        });
    }
};

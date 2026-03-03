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
        Schema::table('carts', function (Blueprint $table) {

            $table->dropTimestamps();

            // Add foreign key for user_id
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete(); // because user_id is nullable

            // Add foreign key for product_id
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {

            // Drop foreign keys
            $table->dropForeign(['user_id']);
            $table->dropForeign(['product_id']);

            // Add timestamps back if rollback
            $table->timestamps();
        });
    }
};

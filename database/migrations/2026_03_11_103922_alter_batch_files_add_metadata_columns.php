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

            // allow single upload without batch
            $table->unsignedBigInteger('batch_id')->nullable()->change();

            // metadata fields
            $table->unsignedBigInteger('category_id')->nullable()->after('user_id');
            $table->unsignedBigInteger('subcategory_id')->nullable()->after('category_id');
            $table->unsignedBigInteger('collection_id')->nullable()->after('subcategory_id');

            // price for marketplace
            $table->decimal('price', 10, 2)->nullable()->after('title');

            // indexes (important for search performance)
            $table->index('category_id');
            $table->index('subcategory_id');
            $table->index('collection_id');

            // optional foreign keys
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->foreign('subcategory_id')->references('id')->on('sub_categories')->cascadeOnDelete();
            $table->foreign('collection_id')->references('id')->on('collections')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batch_files', function (Blueprint $table) {

            $table->dropForeign(['category_id']);
            $table->dropForeign(['subcategory_id']);
            $table->dropForeign(['collection_id']);

            $table->dropColumn([
                'category_id',
                'subcategory_id',
                'collection_id',
                'price'
            ]);
        });
    }
};

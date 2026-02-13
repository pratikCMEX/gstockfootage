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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('collection_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->enum('type', ['1', '0'])->comment('0=>image , 1=>video');
            $table->string('low_path')->nullable();
            $table->string('high_path')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->string('name')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('file_size')->nullable();
            $table->text('description')->nullable();
            $table->text('tags')->nullable();
            $table->enum('is_display', ['1', '0'])->default("1")->comment('0=>no_display , 1=>display');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->foreign('collection_id')->references('id')->on('collections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

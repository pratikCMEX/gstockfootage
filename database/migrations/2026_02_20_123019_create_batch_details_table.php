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

        Schema::create('batch_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('file_code')->unique();

            $table->string('original_name');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('thumbnail_path')->nullable();

            $table->enum('file_type', ['image', 'video']);

            $table->bigInteger('file_size')->nullable();

            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('duration')->nullable(); // for video

            $table->enum('status', [
                'not_submitted',
                'submitted',
                'accepted',
                'rejected',
                'revision',
                'interview'
            ])->default('not_submitted');

            $table->text('rejection_reason')->nullable();


            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batche_details');
    }
};

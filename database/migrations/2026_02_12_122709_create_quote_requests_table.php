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
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->string('company')->nullable();
            $table->string('job_role')->nullable();
            $table->string('job_function')->nullable();
            $table->string('company_size')->nullable();

            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('product_interest')->nullable();

            $table->enum('newsletter', ['0', '1'])->default('0')->comment('1 => checked , 0 => unchecked'); // or wherever you want

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_requests');
    }
};

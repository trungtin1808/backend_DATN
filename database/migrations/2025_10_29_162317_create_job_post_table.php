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
        Schema::create('job_post', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employer_id');
            $table->unsignedBigInteger('job_type_id');
            $table->unsignedBigInteger('category_id');
            $table->string('job_title');
            $table->string('job_description');
            $table->string('job_requirements');
            $table->enum('job_post_status', ['pending', 'accepted', 'rejected', 'expired', 'hidden', 'employer_banned'])->default('pending');
            $table->timestamp('expire_date')->nullable();
            $table->unsignedBigInteger('salaryMin');
            $table->unsignedBigInteger('salaryMax');
            $table->timestamps();

            $table->string('street_address');
            $table->string('state');
            $table->string('city');

            $table->foreign('employer_id')->references('id')->on('company')->onDelete('cascade');
            $table->foreign('job_type_id')->references('id')->on('job_type')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_post');
    }
};

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
            $table->unsignedBigInteger('post_by_id');
            $table->unsignedBigInteger('job_type_id');
            $table->string('job_title');
            $table->string('job_description');
            $table->enum('job_status', ['pending', 'approved', 'rejected', 'expired'])->default('pending');
            $table->date('expire');
            $table->date('date_receive_application');
            $table->unsignedBigInteger('salary');
            $table->unsignedBigInteger('category_id');
            $table->timestamp('approve_at')->nullable();
            $table->timestamps();

            $table->foreign('post_by_id')->references('id')->on('company')->onDelete('cascade');
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

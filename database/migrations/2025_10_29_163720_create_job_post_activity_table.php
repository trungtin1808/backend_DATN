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
        Schema::create('job_post_activity', function (Blueprint $table) {
            $table->unsignedBigInteger('job_post_id');
            $table->unsignedBigInteger('job_seeker_id');
            $table->date('apply_date');
            $table->boolean('is_accept');
            $table->timestamps();

            $table->foreign('job_post_id')->references('id')->on('job_post')->onDelete('cascade');
            $table->foreign('job_seeker_id')->references('id')->on('job_seeker')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_post_activity');
    }
};

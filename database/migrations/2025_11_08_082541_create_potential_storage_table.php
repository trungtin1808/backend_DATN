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
        Schema::create('potential_storage', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_post_id');
            $table->unsignedBigInteger('job_seeker_id');
            $table->timestamps();

            $table->unique(['job_post_id', 'job_seeker_id']);
            
            $table->foreign('job_seeker_id')->references('id')->on('job_seeker')->onDelete('cascade');
            $table->foreign('job_post_id')->references('id')->on('job_post')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('potential_storage');
    }
};

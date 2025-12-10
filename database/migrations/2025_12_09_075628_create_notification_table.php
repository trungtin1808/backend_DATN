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
        Schema::create('notification', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_seeker_id');
            $table->unsignedBigInteger('employer_id');
            $table->unsignedBigInteger('job_post_id');
            $table->text('message');
            $table->boolean('is_read')->default(0);

            $table->foreign('job_post_id')->references('id')->on('job_post')->onDelete('cascade');
            $table->foreign('job_seeker_id')->references('id')->on('job_seeker')->onDelete('cascade');
            $table->foreign('employer_id')->references('id')->on('company')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification');
    }
};

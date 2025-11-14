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
        Schema::create('review', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employer_id');
            $table->unsignedBigInteger('job_seeker_id');
            $table->tinyInteger('rating')->unsigned()->comment('1 to 5');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->unique(['job_seeker_id', 'employer_id']);
            $table->foreign('job_seeker_id')->references('id')->on('job_seeker')->onDelete('cascade');
            $table->foreign('employer_id')->references('id')->on('company')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review');
    }
};

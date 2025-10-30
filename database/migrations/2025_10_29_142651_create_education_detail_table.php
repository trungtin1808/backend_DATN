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
        Schema::create('education_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_seeker_id');
            $table->string('major');
            $table->string('certificate_degree_name');
            $table->string('institute_university_name');
            $table->date('start_date');
            $table->date('complete_date');
            $table->decimal('cgpa');
            $table->timestamps();

            $table->foreign('job_seeker_id')->references('id')->on('job_seeker')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_detail');
    }
};

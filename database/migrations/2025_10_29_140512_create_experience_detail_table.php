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
        Schema::create('experience_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_seeker_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('job_title');
            $table->string('company_name');
            $table->string('job_location');
            $table->string('description');
            $table->timestamps();

            
            $table->foreign('job_seeker_id')->references('id')->on('job_seeker')->onDelete('cascade');
            
        });
        DB::statement('ALTER TABLE experience_detail ADD CONSTRAINT start_before_end CHECK (start_date <= end_date)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experience_detail');
    }
};

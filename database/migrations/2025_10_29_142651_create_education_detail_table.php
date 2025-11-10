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
            $table->enum('education_level', [
                    'secondary',   // THCS
                    'high_school', // THPT
                    'college',     // Cao đẳng
                    'university',  // Đại học
                    'master',      // Thạc sĩ
                    'doctor'       // Tiến sĩ
            ]);
            $table->string('certificate_degree_name');
            $table->string('institute_university_name');
            $table->string('major')->nullable();
            $table->enum('status', ['completed', 'in_progress']);
            $table->date('start_date');
            $table->date('complete_date')->nullable();
            $table->decimal('cgpa', 3, 2)->nullable();
            $table->timestamps();


            $table->foreign('job_seeker_id')->references('id')->on('job_seeker')->onDelete('cascade');
        });
        DB::statement('ALTER TABLE education_detail ADD CONSTRAINT start_before_complete CHECK (start_date < complete_date)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_detail');
    }
};

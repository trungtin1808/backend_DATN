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
        Schema::create('certificate', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_seeker_id');
            $table->string('certificate_name'); // Tên khóa học, ví dụ: Laravel API Course
            $table->string('organization')->nullable(); // Nơi cấp, ví dụ: Udemy, Coursera
            $table->date('issue_date')->nullable(); // Ngày hoàn thành
            $table->date('expire_date')->nullable(); // Nếu không có hạn -> nullable
            $table->string('certificate_url')->nullable(); // Link xem chứng chỉ online
            $table->string('score')->nullable(); // Điểm (nếu có)
            $table->timestamps();

            $table->foreign('job_seeker_id')->references('id')->on('job_seeker')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate');
    }
};

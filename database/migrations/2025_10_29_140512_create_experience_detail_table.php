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
            $table->unsignedBigInteger('id');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('job_title');
            $table->string('company_name');
            $table->string('job_location');
            $table->string('description');

            $table->primary(['id','start_date','end_date']);
            $table->foreign('id')->references('id')->on('job_seeker')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experience_detail');
    }
};

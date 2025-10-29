<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('job_type')->insert([
            ['job_type' => 'full_time'],
            ['job_type' => 'part_time'],
            ['job_type' => 'internship'],
            ['job_type' => 'contract'],
            ['job_type' => 'temporary'],
            ['job_type' => 'remote'],
            ['job_type' => 'freelance'],
            ['job_type' => 'seasonal'],
        ]);
    }
}

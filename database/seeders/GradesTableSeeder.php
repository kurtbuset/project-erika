<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Grade::create([
            'student_id' => 5,
            'class_id' => 3,
            'quarter' => '1st quarter',
            'grade' => 90
        ]);

        Grade::create([
            'student_id' => 5,
            'class_id' => 3,
            'quarter' => '2nd quarter',
            'grade' => 90
        ]);

        Grade::create([
            'student_id' => 5,
            'class_id' => 3,
            'quarter' => '3rd quarter',
            'grade' => 90
        ]);

        Grade::create([
            'student_id' => 5,
            'class_id' => 3,
            'quarter' => '4th quarter',
            'grade' => 90
        ]);
    }
}

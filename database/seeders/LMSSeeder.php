<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use plugins\Course\database\seeders\CourseSeeder;
use plugins\Course\database\seeders\LessonSeeder;
use plugins\Quiz\database\seeders\QuizSeeder;
use plugins\Quiz\database\seeders\QuizAttemptSeeder;
use plugins\Progress\database\seeders\ProgressSeeder;

class LMSSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CourseSeeder::class,
            LessonSeeder::class,
            QuizSeeder::class,
            QuizAttemptSeeder::class,
            ProgressSeeder::class,
        ]);
    }
}

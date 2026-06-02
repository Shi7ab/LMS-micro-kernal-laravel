<?php

namespace plugins\Progress\database\seeders;

use Illuminate\Database\Seeder;
use plugins\Course\src\Models\Lesson;
use plugins\Progress\src\Models\LessonProgress;

class ProgressSeeder extends Seeder
{
    public function run(): void
    {
        $lesson = Lesson::first();

        LessonProgress::create([
            'student_id' => 2,
            'lesson_id' => $lesson->id,
        ]);
    }
}

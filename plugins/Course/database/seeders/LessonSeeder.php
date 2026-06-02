<?php

namespace plugins\Course\database\seeders;

use Illuminate\Database\Seeder;
use plugins\Course\src\Models\Course;
use plugins\Course\src\Models\Lesson;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::first();

        Lesson::create([
            'course_id' => $course->id,
            'title' => 'Introduction',
            'content' => 'Welcome to Laravel',
            'sort_order' => 1,
        ]);

        Lesson::create([
            'course_id' => $course->id,
            'title' => 'Routing',
            'content' => 'Laravel Routing Basics',
            'sort_order' => 2,
        ]);

        Lesson::create([
            'course_id' => $course->id,
            'title' => 'Controllers',
            'content' => 'Laravel Controllers',
            'sort_order' => 3,
        ]);
    }
}

<?php

namespace plugins\Course\database\seeders;

use Illuminate\Database\Seeder;
use plugins\Course\src\Models\Course;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        Course::create([
            'id' => fake()->uuid(),
            'instructor_id' => 1,
            'title' => 'Laravel Fundamentals',
            'description' => 'Learn Laravel from scratch',
            'status' => 'published',
        ]);

        Course::create([
            'id' => fake()->uuid(),
            'instructor_id' => 1,
            'title' => 'Advanced Laravel',
            'description' => 'Advanced concepts',
            'status' => 'draft',
        ]);
    }
}

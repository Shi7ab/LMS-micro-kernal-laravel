<?php

namespace plugins\Quiz\database\seeders;

use Illuminate\Database\Seeder;
use plugins\Quiz\src\Models\Quiz;
use plugins\Quiz\src\Models\QuizAttempt;

class QuizAttemptSeeder extends Seeder
{
    public function run(): void
    {
        $quiz = Quiz::first();

        QuizAttempt::create([
            'student_id' => 2,
            'quiz_id' => $quiz->id,
            'score' => 85,
            'is_passed' => true,
        ]);
    }
}

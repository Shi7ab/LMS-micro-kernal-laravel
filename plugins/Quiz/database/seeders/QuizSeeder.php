<?php

namespace plugins\Quiz\database\seeders;

use Illuminate\Database\Seeder;
use plugins\Course\src\Models\Lesson;
use plugins\Quiz\src\Models\Quiz;
use plugins\Quiz\src\Models\Question;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $lesson = Lesson::first();

        $quiz = Quiz::create([
            'lesson_id' => $lesson->id,
            'title' => 'Lesson 1 Quiz',
            'passing_score' => 70,
        ]);

        Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'What is Laravel?',
            'options' => json_encode([
                'Framework',
                'Database',
                'Server'
            ]),
            'correct_option' => 'Framework',
        ]);

        Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'Which language Laravel uses?',
            'options' => json_encode([
                'Java',
                'PHP',
                'Python'
            ]),
            'correct_option' => 'PHP',
        ]);
    }
}

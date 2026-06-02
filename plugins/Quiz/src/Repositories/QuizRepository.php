<?php

namespace plugins\Quiz\src\Repositories;

use Illuminate\Support\Facades\DB;
use plugins\Quiz\src\Models\Quiz;

class QuizRepository
{
    public function createQuiz(array $data): Quiz
    {
        return DB::transaction(function () use ($data) {

            $quiz = Quiz::create([
                'lesson_id'     => $data['lesson_id'],
                'title'         => $data['title'],
                'passing_score' => $data['passing_score'],
            ]);

            $questions = collect($data['questions'])
                ->map(function ($question) {

                    return [
                        'question_text' => $question['question_text'],
                        'options' => json_encode(
                            $question['options']
                        ),
                        'correct_option' => $question['correct_option'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                })
                ->toArray();

            $quiz->questions()
                ->createMany($questions);

            return $quiz->load('questions');
        });
    }

    public function findWithQuestions(
        string $quizId
    ): Quiz {

        return Quiz::with('questions')
            ->findOrFail($quizId);
    }
}

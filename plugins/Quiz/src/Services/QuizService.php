<?php

namespace plugins\Quiz\src\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use plugins\Quiz\src\Models\Quiz;
use plugins\Quiz\src\Models\QuizAttempt;
use plugins\Quiz\src\Events\QuizPassed;


class QuizService
{
    /**
     * Create new quiz with questions
     **/
    public function create(array $data): Quiz
    {
        return DB::transaction(function () use ($data) {

            $quiz = Quiz::create([
                'lesson_id'      => $data['lesson_id'],
                'title'          => $data['title'],
                'passing_score'  => $data['passing_score'],
            ]);

            $questions = collect($data['questions'])->map(function ($question) {

                return [
                    'question_text' => $question['question_text'],
                    'options'        => json_encode($question['options']),
                    'correct_option' => $question['correct_option'],
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
            })->toArray();

            $quiz->questions()->createMany($questions);

            return $quiz->load('questions');
        });
    }

    /**
     * Submit quiz answers with specific question id
     */
    public function submit(array $data, string $quizId, string $studentId): array
    {
        $quiz = Quiz::with('questions')->findOrFail($quizId);

        $questions = $quiz->questions;

        if ($questions->isEmpty()) {
            throw new \Exception('Quiz has no questions');
        }

        $correctAnswersCount = 0;

        foreach ($questions as $question) {

            $studentAnswer = $data['answers'][$question->id] ?? null;

            if (
                !is_null($studentAnswer) &&
                $studentAnswer === $question->correct_option
            ) {
                $correctAnswersCount++;
            }
        }

        $totalQuestions = $questions->count();

        $score = round(
            ($correctAnswersCount / $totalQuestions) * 100,
            2
        );

        $isPassed = $score >= $quiz->passing_score;

        $attempt = QuizAttempt::create([
            'student_id' => $studentId,
            'quiz_id'    => $quiz->id,
            'score'      => $score,
            'is_passed'  => $isPassed,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Fire Domain Event
        |--------------------------------------------------------------------------
        */

        if ($isPassed) {

            Event::dispatch(new QuizPassed(
                $studentId,
                $quiz->lesson_id,
                $quiz->id,
                $score
            ));
        }

        return [
            'attempt_id'      => $attempt->id,
            'score'           => $score,
            'is_passed'       => $isPassed,
            'correct_answers' => $correctAnswersCount,
            'total_questions' => $totalQuestions,
        ];
    }
}

<?php

namespace plugins\Quiz\src\Services;

use Illuminate\Support\Facades\Event;
use plugins\Quiz\src\Events\QuizPassed;
use plugins\Quiz\src\Repositories\QuizRepository;
use plugins\Quiz\src\Repositories\QuizAttemptRepository;

class QuizSubmissionService
{
    public function __construct(
        protected QuizRepository $quizRepository,
        protected QuizAttemptRepository $attemptRepository
    ) {}

    public function submit(
        array $answers,
        string $quizId,
        string $studentId
    ): array {

        $quiz = $this->quizRepository
            ->findWithQuestions($quizId);

        if ($quiz->questions->isEmpty()) {
            throw new \Exception(
                'Quiz has no questions'
            );
        }

        $correctAnswers = 0;

        foreach ($quiz->questions as $question) {

            $studentAnswer =
                $answers[$question->id] ?? null;

            if (
                $studentAnswer !== null &&
                $studentAnswer === $question->correct_option
            ) {
                $correctAnswers++;
            }
        }

        $totalQuestions =
            $quiz->questions->count();

        $score = round(
            ($correctAnswers / $totalQuestions) * 100,
            2
        );

        $isPassed =
            $score >= $quiz->passing_score;

        $attempt = $this->attemptRepository
            ->create([
                'student_id' => $studentId,
                'quiz_id' => $quizId,
                'score' => $score,
                'is_passed' => $isPassed,
            ]);

        if ($isPassed) {

            Event::dispatch(
                new QuizPassed(
                    $studentId,
                    $quiz->lesson_id,
                    $quizId,
                    $score
                )
            );
        }

        return [
            'attempt_id' => $attempt->id,
            'score' => $score,
            'is_passed' => $isPassed,
            'correct_answers' => $correctAnswers,
            'total_questions' => $totalQuestions,
        ];
    }
}

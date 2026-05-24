<?php

namespace plugins\Quiz\src\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuizPassed
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $studentId,
        public string $lessonId,
        public string $quizId,
        public float $score
    ) {
    }
}

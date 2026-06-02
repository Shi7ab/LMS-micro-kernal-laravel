<?php

namespace plugins\Quiz\src\Services;

use plugins\Quiz\src\Repositories\QuizRepository;

class QuizService
{
    public function __construct(
        protected QuizRepository $quizRepository
    ) {}

    public function create(array $data)
    {
        return $this->quizRepository
            ->createQuiz($data);
    }

    public function findById(string $quizId)
    {
        return $this->quizRepository
            ->findWithQuestions($quizId);
    }
}

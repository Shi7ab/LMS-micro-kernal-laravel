<?php
namespace plugins\Quiz\src\Repositories;

use plugins\Quiz\src\Models\QuizAttempt;

class QuizAttemptRepository
{
    public function create(array $data)
    {
        return QuizAttempt::create($data);
    }
}

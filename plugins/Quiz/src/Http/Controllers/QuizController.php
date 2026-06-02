<?php

namespace plugins\Quiz\src\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Kernel\Support\ApiResponse;
use plugins\Quiz\src\Services\QuizService;

class QuizController extends Controller
{
    public function __construct(
        private readonly QuizService $quizService
    ) {}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lesson_id' => ['required', 'uuid'],
            'title' => ['required', 'string'],
            'passing_score' => [
                'required',
                'numeric',
                'min:0',
                'max:100'
            ],
            'questions' => ['required', 'array'],
        ]);

        $quiz = $this->quizService
            ->create($validated);

        return ApiResponse::success(
            $quiz,
            'Quiz created successfully',
            201
        );
    }
}

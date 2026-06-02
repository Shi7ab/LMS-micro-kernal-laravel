<?php

namespace plugins\Quiz\src\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Kernel\Support\ApiResponse;
use plugins\Quiz\src\Services\QuizSubmissionService;

class QuizSubmissionController extends Controller
{
    public function __construct(
        private readonly QuizSubmissionService $submissionService
    ) {}

    public function submit(
        Request $request,
        string $quizId
    ) {

        $validated = $request->validate([
            'answers' => ['required', 'array']
        ]);

        $result =
            $this->submissionService->submit(
                $validated['answers'],
                $quizId,
                auth()->id()
            );

        return ApiResponse::success(
            $result,
            'Quiz submitted successfully'
        );
    }
}

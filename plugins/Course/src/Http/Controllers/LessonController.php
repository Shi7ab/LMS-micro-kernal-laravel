<?php

namespace plugins\Course\src\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Kernel\Support\ApiResponse;
use plugins\Course\src\Services\LessonService;

class LessonController extends Controller
{
    public function __construct(
        private readonly LessonService $lessonService
    ) {}

    /**
     * Add lesson to course
     */
    public function store(Request $request, string $courseId)
    {
        $validated = $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
        ]);

        $lesson = $this->lessonService->addLesson(
            $courseId,
            $validated
        );

        return ApiResponse::success(
            $lesson,
            'Lesson created successfully',
            201
        );
    }

    /**
     * Get all lessons
     */
    public function index()
    {
        return ApiResponse::success(
            $this->lessonService->findAllLesson()
        );
    }

    /**
     * Reorder lessons
     */
    public function reorder(Request $request, string $courseId)
    {
        $validated = $request->validate([
            'lessons' => ['required', 'array'],
            'lessons.*.id' => ['required', 'uuid'],
            'lessons.*.sort_order' => ['required', 'integer'],
        ]);

        $this->lessonService->reorderLessons(
            $validated['lessons'],
            $courseId
        );

        return ApiResponse::success(
            null,
            'Lessons reordered successfully'
        );
    }
}

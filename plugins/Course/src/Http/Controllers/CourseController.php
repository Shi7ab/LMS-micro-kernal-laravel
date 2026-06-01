<?php

namespace plugins\Course\src\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Kernel\Support\ApiResponse;
use plugins\Course\src\Services\CourseService;

class CourseController extends Controller
{
    public function __construct(
        private readonly CourseService $service
    ) {}

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return ApiResponse::error('Unauthenticated', 401);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $course = $this->service->create($validated);

        return ApiResponse::success(
            $course,
            'Course created successfully',
            201
        );
    }

   public function addLesson(Request $request, string $courseId)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
        ]);

        $lesson = $this->service->addLesson($courseId, $validated);

        return ApiResponse::success(
            $lesson,
            'Lesson added successfully',
            201
        );
    }

    public function findAllLesson()
    {
        return ApiResponse::success(
            $this->service->findAllLesson()
        );
    }

    public function findAll()
    {
        return ApiResponse::success(
            $this->service->findAllCourse()
        );
    }

    public function publish(string $courseId)
    {
        $course = $this->service->publish($courseId);

        return ApiResponse::success(
            $course,
            'Course published successfully'
        );
    }

    public function reorderLessons(Request $request, string $courseId)
    {
        $validated = $request->validate([
            'lessons' => ['required', 'array'],
            'lessons.*.id' => ['required', 'uuid'],
            'lessons.*.sort_order' => ['required', 'integer'],
        ]);

        $this->service->reorderLessons($courseId, $validated['lessons']);

        return ApiResponse::success(
            null,
            'Lessons reordered successfully'
        );
    }
}

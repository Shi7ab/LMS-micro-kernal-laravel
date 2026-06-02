<?php

namespace plugins\Course\src\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Kernel\Support\ApiResponse;
use plugins\Course\src\Services\CourseService;
use plugins\Course\src\Services\CoursePublishingService;
class CourseController extends Controller
{
    public function __construct(
        private readonly CourseService $courseService,
        private readonly CoursePublishingService $coursePublish
    ) {}

    /**
     * Create new course
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $course = $this->courseService->create($validated);

        return ApiResponse::success(
            $course,
            'Course created successfully',
            201
        );
    }

    /**
     * Get all courses
     */
    public function index()
    {
        return ApiResponse::success(
            $this->courseService->findAllCourse()
        );
    }

    public function publish(string $courseId)
    {
        $course = $this->coursePublish->publish($courseId);

        return ApiResponse::success(
            $course,
            'Course published successfully'
        );
    }
}

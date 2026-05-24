<?php

namespace plugins\Course\src\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Event;

use Kernel\Support\ApiResponse;
use plugins\Course\src\Models\Course;
use plugins\Course\src\Models\Lesson;

class CourseController extends Controller
{
    /**
     * Create new course
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $userId = auth()->id();

        if (!$userId) {
            return ApiResponse::error('Unauthenticated', 401);
        }

        $course = Course::create([
            'instructor_id' => $userId,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => 'draft',
        ]);

        return ApiResponse::success(
            $course,
            'Course created successfully',
            201
        );
    }

    /**
     * Add lesson to course
     */
    public function addLesson(Request $request, string $courseId)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
        ]);

        $course = Course::findOrFail($courseId);

        $lastOrder = $course->lessons()->max('sort_order') ?? 0;

        $lesson = $course->lessons()->create([
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'sort_order' => $lastOrder + 1,
        ]);

        return ApiResponse::success(
            $lesson,
            'Lesson added successfully',
            201
        );
    }

    /**
     * Publish course
     */
    public function publish(string $courseId)
    {
        $course = Course::findOrFail($courseId);

        $course->update([
            'status' => 'published'
        ]);

        Event::dispatch('course.published', $course);

        return ApiResponse::success(
            $course,
            'Course published successfully'
        );
    }

    /**
     * Reorder lessons
     */
    public function reorderLessons(Request $request, string $courseId)
    {
        $validated = $request->validate([
            'lessons' => ['required', 'array'],
            'lessons.*.id' => ['required', 'uuid'],
            'lessons.*.sort_order' => ['required', 'integer'],
        ]);

        $course = Course::findOrFail($courseId);

        foreach ($validated['lessons'] as $lessonData) {
            $course->lessons()
                ->where('id', $lessonData['id'])
                ->update([
                    'sort_order' => $lessonData['sort_order']
                ]);
        }

        return ApiResponse::success(
            null,
            'Lessons reordered successfully'
        );
    }
}

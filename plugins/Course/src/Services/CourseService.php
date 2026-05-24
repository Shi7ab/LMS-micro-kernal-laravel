<?php

namespace plugins\Course\src\Services\CourseService;

use Illuminate\Http\Request;
use Plugins\Courses\Models\Course;
use Plugins\Courses\Models\Lesson;
use Illuminate\Support\Facades\Event;

class CourseService
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max::255',
            'description' => 'nullable|string'
        ]);

        // check the user_id in the keranl - Auth Middleware
        $course = Course::create([
            'instructor_id' => $request->attributes->get('user_id'),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => 'draft'
        ]);

        return response()->json(['status' => 'success', 'data' => $course], 201);
    }

    // add new lesson
    public function addLesson(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string'
        ]);

        $lastOrder = $course->lessons()->max('sort_order') ?? 0;

        $lesson = $course->lessons()->create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'sort_order' => $lastOrder + 1
        ]);

        return $lesson;
    }

    // course life sycle (Draft -> Published)
    public function publish($id)
    {
        $course = Course::findOrFail($id);
        $course->update(['status' => 'published']);

        // create new event for the listener
        Event::dispatch('course.published', [$course]);

        return $id;
    }

    // restore the lessons (Content Ordering)
    public function reorderLessons(Request $request, $courseId)
    {
        $validated = $request->validate([
            'lessons' => 'required|array',
            'lessons.*.id' => 'required|uuid',
            'lessons.*.sort_order' => 'required|integer'
        ]);

        foreach ($validated['lessons'] as $lessonData) {
            Lesson::where('id', $lessonData['id'])
                  ->where('course_id', $courseId)
                  ->update(['sort_order' => $lessonData['sort_order']]);
        }

        return  $courseId;
    }

}

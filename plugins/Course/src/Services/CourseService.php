<?php

namespace plugins\Course\src\Services;

use Illuminate\Http\Request;
use plugins\Course\src\Models\Lesson;
use plugins\Course\src\Models\Course;
use Illuminate\Support\Facades\Event;

class CourseService
{

    public function create(array $data)
    {
        $validated =  $data;

        // check the user_id in the keranl - Auth Middleware

        $course = Course::create([
            'instructor_id' => auth()->id(),
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => 'draft'
        ]);

        return $course;
    }

    // add new lesson
   public function addLesson(string $courseId, array $data)
    {
        $course = Course::findOrFail($courseId);

        $lastOrder = $course->lessons()->max('sort_order') ?? 0;

        return $course->lessons()->create([
            'title' => $data['title'],
            'content' => $data['content'] ?? null,
            'sort_order' => $lastOrder + 1
        ]);
    }

    // find all lesson
    public function findAllLesson(){
        return Lesson::all();
    }

    //  find all courses
    public function findAllCourse(){
            $course = Course::All();

            return ApiResponse::success(
                $course
            );
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
    public function reorderLessons(array $request, $courseId)
    {
        $validated = $request;

        foreach ($lessons as $lessonData) {
            Lesson::where('id', $lessonData['id'])
                ->where('course_id', $courseId)
                ->update([
                    'sort_order' => $lessonData['sort_order']
                ]);
        }

        return true;
    }

}

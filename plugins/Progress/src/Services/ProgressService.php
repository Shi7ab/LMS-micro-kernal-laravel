<?php

namespace plugins\Progress\src\Services;


use plugins\Progress\src\Models\LessonProgress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProgressService
{


    public function markAsComplete(string $lessonId)
    {
        $studentId = Auth::id();

        return LessonProgress::firstOrCreate([
            'student_id' => $studentId,
            'lesson_id' => $lessonId,
        ]);
    }
    
    public function getCourseProgress(string $studentId, string $courseId)
    {
        // $studentId = $request->attributes->get('user_id');
        $studentId = Auth::id();

        $totalLessons = DB::table('lessons')->where('course_id', $courseId)->count();

        if ($totalLessons === 0) {
            return response()->json(['status' => 'success', 'progress_percentage' => 0]);
        }

        $completedLessons = DB::table('student_lesson_progress')
            ->join('lessons', 'student_lesson_progress.lesson_id', '=', 'lessons.id')
            ->where('student_lesson_progress.student_id', $studentId)
            ->where('lessons.course_id', $courseId)
            ->count();

        $percentage = ($completedLessons / $totalLessons) * 100;

        return response()->json([
            'status' => 'success',
            'data' => [
                'course_id' => $courseId,
                'total_lessons' => $totalLessons,
                'completed_lessons' => $completedLessons,
                'progress_percentage' => round($percentage, 2) . '%'
            ]
        ]);
    }

}



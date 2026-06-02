<?php
namespace plugins\Progress\src\Repositories;

use Illuminate\Support\Facades\DB;
use plugins\Progress\src\Models\LessonProgress;
use plugins\Progress\src\Contracts\ProgressRepositoryInterface;

class ProgressRepository
    implements ProgressRepositoryInterface
{
    public function markAsComplete(
        string $studentId,
        string $lessonId
    ) {
        return LessonProgress::firstOrCreate([
            'student_id' => $studentId,
            'lesson_id' => $lessonId,
        ]);
    }

    public function getTotalLessonsCount(
        string $courseId
    ): int {
        return DB::table('lessons')
            ->where('course_id', $courseId)
            ->count();
    }

    public function getCompletedLessonsCount(
        string $studentId,
        string $courseId
    ): int {
        return DB::table('student_lesson_progress')
            ->join(
                'lessons',
                'student_lesson_progress.lesson_id',
                '=',
                'lessons.id'
            )
            ->where(
                'student_lesson_progress.student_id',
                $studentId
            )
            ->where(
                'lessons.course_id',
                $courseId
            )
            ->count();
    }
}

<?php

namespace plugins\Progress\src\Services;

use plugins\Progress\src\Models\LessonProgress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use plugins\Progress\src\Repositories\ProgressRepository;

class ProgressService
{
    public function __construct(
        private ProgressRepository $repository
    ) {}

 /**
     * Mark a lesson as completed for the currently authenticated student.
     *
     * If a progress record already exists for this student and lesson,
     * firstOrCreate will return the existing record.
     * Otherwise, it will create a new one.
     *
     * @param string $lessonId
     * @return LessonProgress
     */

    public function markAsComplete(string $lessonId)
    {
        // Get the currently authenticated student's ID
        $studentId = Auth::id();
        // Create progress record if it does not exist
         return $this->repository->markAsComplete(
            auth()->id(),
            $lessonId
        );
    }

    /**
     * Calculate the completion percentage for a course.
     *
     * Progress is calculated using:
     * (completed lessons / total lessons) * 100
     *
     * @param string $studentId
     * @param string $courseId
     * @return \Illuminate\Http\JsonResponse
     */

    public function getCourseProgress(string $courseId): array
    {
        $studentId = Auth::id();

        $totalLessons = $this->repository
            ->getTotalLessonsCount($courseId);

        if ($totalLessons === 0) {
            return [
                'status' => 'success',
                'progress_percentage' => 0,
            ];
        }

        $completedLessons = $this->repository
            ->getCompletedLessonsCount(
                $studentId,
                $courseId
            );

        $percentage = ($completedLessons / $totalLessons) * 100;

        return [
            'status' => 'success',
            'data' => [
                'course_id' => $courseId,
                'total_lessons' => $totalLessons,
                'completed_lessons' => $completedLessons,
                'progress_percentage' => round($percentage, 2) . '%',
            ]
        ];
    }

}

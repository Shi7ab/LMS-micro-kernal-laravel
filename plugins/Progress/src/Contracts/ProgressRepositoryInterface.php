<?php
namespace plugins\Progress\src\Contracts;

interface ProgressRepositoryInterface
{
    public function markAsComplete(
        string $studentId,
        string $lessonId
    );

    public function getCompletedLessonsCount(
        string $studentId,
        string $courseId
    ): int;

    public function getTotalLessonsCount(
        string $courseId
    ): int;
}

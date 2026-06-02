<?php

namespace plugins\Course\src\Services;

use plugins\Course\src\Repositories\CourseRepository;
use plugins\Course\src\Repositories\LessonRepository;

class LessonService
{
    public function __construct(
        protected LessonRepository $lessonRepository,
        protected CourseRepository $courseRepository
    ) {}

    /**
     * Add lesson to course
     */
    public function addLesson(
        string $courseId,
        array $data
    ) {
        $course = $this->courseRepository
            ->getCourseById($courseId);

        $lastOrder = $course
            ->lessons()
            ->max('sort_order') ?? 0;

        return $this->lessonRepository->create([
            'course_id'  => $courseId,
            'title'      => $data['title'],
            'content'    => $data['content'] ?? null,
            'sort_order' => $lastOrder + 1,
        ]);
    }

    /**
     * Get all lessons
     */
    public function findAllLesson()
    {
        return $this->lessonRepository->getAll();
    }

    /**
     * Get lesson by id
     */
    public function findById(string $lessonId)
    {
        return $this->lessonRepository->getLessonById($lessonId);
    }

    /**
     * Update lesson
     */
    public function updateLesson(
        string $lessonId,
        array $data
    ) {
        return $this->lessonRepository
            ->updateLesson($lessonId, $data);
    }

    /**
     * Delete lesson
     */
    public function deleteLesson(
        string $lessonId
    ) {
        return $this->lessonRepository
            ->deleteLesson($lessonId);
    }

    /**
     * Reorder lessons
     */
    public function reorderLessons(
        string $courseId,
        array $lessons
    ): bool {
        foreach ($lessons as $lesson) {
            $this->lessonRepository->updateSortOrder(
                $lesson['id'],
                $courseId,
                $lesson['sort_order']
            );
        }

        return true;
    }
}

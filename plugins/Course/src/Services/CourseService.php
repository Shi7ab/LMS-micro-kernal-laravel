<?php

namespace plugins\Course\src\Services;

use plugins\Course\src\Repositories\CourseRepository;

class CourseService
{
    public function __construct(
        protected CourseRepository $courseRepository
    ) {}

    /**
     * Create new course
     */
    public function create(array $data)
    {
        return $this->courseRepository->createCourse([
            'instructor_id' => auth()->id(),
            'title'         => $data['title'],
            'description'   => $data['description'] ?? null,
            'status'        => 'draft',
        ]);
    }

    /**
     * Get all courses
     */
    public function findAllCourse()
    {
        return $this->courseRepository->getAllCourse();
    }

    /**
     * Get course by id
     */
    public function findById(string $courseId)
    {
        return $this->courseRepository->getCourseById($courseId);
    }

    /**
     * Update course
     */
    public function update(string $courseId, array $data)
    {
        return $this->courseRepository->updateCourse(
            $data,
            $courseId
        );
    }

    /**
     * Delete course
     */
    public function delete(string $courseId)
    {
        return $this->courseRepository->deleteCourse($courseId);
    }
}

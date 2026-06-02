<?php

namespace plugins\Course\src\Services;

use Illuminate\Support\Facades\Event;
use plugins\Course\src\Repositories\CourseRepository;

class CoursePublishService
{
    public function __construct(
        protected CourseRepository $repository
    ) {}

    public function publish(
        string $courseId
    ): void
    {
        $course = $this->repository
            ->getCourseById($courseId);

        $this->repository->updateCourse([
            'status' => 'published'
        ], $courseId);

        Event::dispatch(
            'course.published',
            [$course]
        );
    }
}

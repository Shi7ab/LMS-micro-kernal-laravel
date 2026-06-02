<?php
namespace plugins\Course\src\Services;
use Illuminate\Support\Facades\Event;
use plugins\Course\src\Repositories\CourseRepository;

class CoursePublishingService
{
    public function __construct(
        private CourseRepository $courseRepository
    ) {}

    public function publish(string $courseId)
    {
        $course = $this->courseRepository->updateCourse([
            'status' => 'published'
        ], $courseId);

        Event::dispatch('course.published', [$course]);

        return $course;
    }
}

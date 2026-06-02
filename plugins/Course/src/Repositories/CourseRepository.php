<?php

namespace plugins\Course\src\Repositories;

use plugins\Course\src\Models\Course;

class CourseRepository
{
    public function createCourse(array $data): Course
    {
        return Course::create($data);
    }

    public function getAllCourse()
    {
        return Course::all();
    }

    public function getCourseById(string $id): Course
    {
        return Course::findOrFail($id);
    }

    public function updateCourse(array $data, string $id): Course
    {
        $course = Course::findOrFail($id);

        $course->update($data);

        return $course->fresh();
    }

    public function deleteCourse(string $id): bool
    {
        return Course::findOrFail($id)->delete();
    }
}

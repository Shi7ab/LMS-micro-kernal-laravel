<?php

namespace plugins\Course\src\Contracts;

interface CourseServiceInterface
{
    public function create(array $data);

    public function findAllCourse();

    public function publish(string $courseId);

    public function update(string $courseId, array $data);

    public function delete(string $courseId);
}

<?php

namespace plugins\Course\src\Contracts;

interface LessonServiceInterface
{
    public function create(array $data);

    public function findAlllesson();

    public function publish(string $lessonId);

    public function update(string $lessonId, array $data);

    public function delete(string $lessonId);
}

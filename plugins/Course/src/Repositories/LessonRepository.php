<?php

namespace plugins\Course\src\Repositories;

use plugins\Course\src\Models\Lesson;

class LessonRepository
{
    public function create(array $data)
    {
        return Lesson::create($data);
    }

    public function getAll()
    {
        return Lesson::all();
    }

    public function updateSortOrder(
        string $lessonId,
        string $courseId,
        int $sortOrder
    ): bool {
        return Lesson::where('id', $lessonId)
            ->where('course_id', $courseId)
            ->update([
                'sort_order' => $sortOrder
            ]);
    }
}

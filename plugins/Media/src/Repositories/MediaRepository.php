<?php

namespace plugins\Media\src\Repositories;

use Illuminate\Database\Eloquent\Collection;
use plugins\Media\src\Models\LessonMedia;

class MediaRepository
{
    /**
     * Create media record
     */
    public function create(array $data): LessonMedia
    {
        return LessonMedia::create($data);
    }

    /**
     * Get lesson media
     */
    public function getByLesson(
        string $lessonId
    ): Collection {
        return LessonMedia::query()
            ->where('lesson_id', $lessonId)
            ->latest()
            ->get();
    }
}

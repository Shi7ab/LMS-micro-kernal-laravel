<?php

namespace plugins\Media\src\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use plugins\Media\src\Events\MediaUploaded;
use plugins\Media\src\Models\LessonMedia;
use plugins\Media\src\Repositories\MediaRepository;

class MediaService
{
    public function __construct(
        private readonly MediaRepository $mediaRepository
    ) {}

    /**
     * Upload media file
     */
    public function upload(
        string $lessonId,
        UploadedFile $file
    ): LessonMedia {

        return DB::transaction(function () use (
            $lessonId,
            $file
        ) {

            $path = $file->store(
                'media',
                'public'
            );

            $media = $this->mediaRepository->create([
                'lesson_id'     => $lessonId,
                'file_name'     => $file->getClientOriginalName(),
                'file_path'     => Storage::url($path),
                'file_type'     => $file->getMimeType(),
                'size_in_bytes' => $file->getSize(),
            ]);

            MediaUploaded::dispatch($media);

            return $media;
        });
    }

    /**
     * Get lesson media
     */
    public function getMediaByLesson(
        string $lessonId
    ): Collection {
        return $this->mediaRepository->getByLesson(
            $lessonId
        );
    }
}

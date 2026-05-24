<?php

namespace Plugins\Media\src\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Plugins\Media\src\Models\LessonMedia;
use Illuminate\Support\Facades\Storage;


class MediaService
{
    /**
     * Upload and attach media file.
     *
     * @param UploadedFile $file
     * @param string|null $lessonId
     * @return array
     */
    public function attach(UploadedFile $file, ?string $lessonId = null): array
    {

       $file = $request->file('file');

        //  store in this folder (storage/app/public/media)
        $path = $file->store('public/media');

        $media = LessonMedia::create([
            'lesson_id' => $validated['lesson_id'],
            'file_name' => $file->getClientOriginalName(),
            'file_path' => Storage::url($path), //  for example: /storage/media/filename.mp4
            'file_type' => $file->getClientMimeType(),
            'size_in_bytes' => $file->getSize(),
        ]);

        return $media;
    }
}

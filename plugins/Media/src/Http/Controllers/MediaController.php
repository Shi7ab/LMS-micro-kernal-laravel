<?php

namespace plugins\Media\src\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use plugins\Media\src\Services\MediaService;

class MediaController extends Controller
{
    public function __construct(
        private readonly MediaService $mediaService
    ) {}

    public function upload(Request $request): JsonResponse
    {

        $validated = $request->validate([
            'lesson_id' => ['required', 'uuid'],
            'file' => [
                'required',
                'file',
                'mimes:mp4,mov,avi,pdf,docx,zip,png,jpg',
                'max:51200',
            ],
        ]);

        $media = $this->mediaService->upload(
            lessonId: $validated['lesson_id'],
            file: $request->file('file')
        );


        return response()->json([
            'status' => 'success',
            'message' => 'Resource uploaded successfully.',
            'data' => $media,
        ], 201);
    }

    public function getMediaByLesson(string $lessonId): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->mediaService->getMediaByLesson($lessonId),
        ]);
    }
}

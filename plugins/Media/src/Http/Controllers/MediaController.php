<?php
// plugins/Media/src/Http/Controllers/MediaController.php

namespace Plugins\Media\src\Http\Controllers;

// use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Plugins\Media\src\Models\LessonMedia;
use Illuminate\Support\Facades\Storage;
// use plugins\Media\src\Services\MediaService;

class MediaController extends Controller
{
    /*
    public $service;
    public function __construct(MediaService $service){
        $this->servicr = $service;
    }*/
    /**
     * upload the file
     */
    public function upload(Request $request)
    {

        $validated = $request->validate([
            'lesson_id' => 'required|uuid',
            'file' => 'required|file|mimes:mp4,mov,avi,pdf,docx,zip,png,jpg|max:51200',
        ]);

       // $media = $service->attach($validated);

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

       // return $media;
        return response()->json([
            'status' => 'success',
            'message' => 'Resource uploaded and attached successfully.',
            'data' => $media
        ], 201);
    }

    /**
     *  get all the files that stored with significant lesson
     */
    public function getMediaByLesson($lessonId)
    {
        $media = LessonMedia::where('lesson_id', $lessonId)->get();

        return response()->json([
            'status' => 'success',
            'data' => $media
        ], 200);
    }
}

<?php

namespace plugins\Progress\src\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use plugins\Progress\src\Services\ProgressService;

class ProgressController extends Controller
{
    protected ProgressService $service;

    public function __construct(ProgressService $service)
    {
        $this->service = $service;
    }

    /**
     * Mark lesson as completed
     */
    
    public function markAsComplete(Request $request, string $lessonId)
    {
        $studentId = auth()->id();

        $progress = $this->service->markAsComplete(
            $studentId,
            $lessonId
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Lesson marked as completed successfully.',
            'data' => $progress,
        ], 200);
    }

    /**
     * Get course progress
     */
    public function getCourseProgress(Request $request, string $courseId)
    {
        $studentId = auth()->id();

        $progress = $this->service->getCourseProgress(
            $studentId,
            $courseId
        );

        return response()->json([
            'status' => 'success',
            'data' => $progress,
        ], 200);
    }
}

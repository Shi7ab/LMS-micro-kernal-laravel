<?php

namespace Plugins\Enrollment\src\Http\Controllers;

//use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Plugins\Enrollment\src\Services\EnrollmentService;

class EnrollmentController extends Controller
{

    protected EnrollmentService $enrollmentService;

    public function __construct(EnrollmentService $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;
    }


    public function enroll(Request $request): JsonResponse
    {

        $validated = $request->validate([
            'course_id'  => 'required|uuid',
            'student_id' => 'required|uuid'
        ]);


        $enrollmentId = $this->enrollmentService->enroll($validated);


        return response()->json([
            'status'  => 'success',
            'message' => 'Student enrolled effectively.',
            'data'    => [
                'id' => $enrollmentId
            ]
        ], 201);
    }
}

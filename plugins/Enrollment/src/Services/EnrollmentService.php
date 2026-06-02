<?php

namespace plugins\Enrollment\src\Services;

use Illuminate\Support\Str;
use plugins\Enrollment\src\Events\EnrollmentCreated;
use plugins\Enrollment\src\Repositories\EnrollmentRepository;

class EnrollmentService
{
    public function __construct(
        private readonly EnrollmentRepository $enrollmentRepository
    ) {}

    /**
     * Enroll student in course
     */
    public function enroll(array $data): string
    {
        $enrollmentId = (string) Str::uuid();

        $this->enrollmentRepository->enroll([
            'id'         => $enrollmentId,
            'course_id'  => $data['course_id'],
            'student_id' => $data['student_id'],
        ]);

        event(new EnrollmentCreated([
            'enrollment_id' => $enrollmentId,
            'student_id'    => $data['student_id'],
            'course_id'     => $data['course_id'],
        ]));

        return $enrollmentId;
    }
}

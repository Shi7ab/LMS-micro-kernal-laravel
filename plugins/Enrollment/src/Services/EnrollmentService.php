<?php

namespace Plugins\Enrollment\src\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Plugins\Enrollment\src\Events\EnrollmentCreated;

class EnrollmentService
{
    /**
     *
     *
     * @param array
     * @return string
     */

    public function enroll(array $data): string
    {

        $enrollmentId = (string) Str::uuid();

        DB::transaction(function () use ($data, $enrollmentId) {
            DB::table('enrollments')->insert([
                'id'           => $enrollmentId,
                'course_id'    => $data['course_id'],
                'student_id'   => $data['student_id'],
                'status'       => 'active',
                'enrolled_at'  => now(),
                'completed_at' => null,
                'created_at'   => now(),
                'updated_at'   => now()
            ]);
        });
    
        event(new EnrollmentCreated([
            'enrollment_id' => $enrollmentId,
            'student_id'    => $data['student_id'],
            'course_id'     => $data['course_id']
        ]));

        return $enrollmentId;
    }
}

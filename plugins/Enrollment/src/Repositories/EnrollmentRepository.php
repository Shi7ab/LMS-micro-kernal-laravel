<?php

namespace plugins\Enrollment\src\Repositories;

use Illuminate\Support\Facades\DB;

class EnrollmentRepository
{
    /**
     * Create enrollment record
     */
    public function enroll(array $data): bool
    {
        return DB::table('enrollments')->insert([
            'id'           => $data['id'],
            'course_id'    => $data['course_id'],
            'student_id'   => $data['student_id'],
            'status'       => 'active',
            'enrolled_at'  => now(),
            'completed_at' => null,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
    }
}

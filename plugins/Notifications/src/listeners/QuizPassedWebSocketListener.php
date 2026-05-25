<?php
// plugins/Notifications/src/Listeners/QuizPassedWebSocketListener.php

namespace Plugins\Notifications\src\Listeners;

use App\Events\LiveNotificationEvent;
use Illuminate\Support\Facades\DB;

class QuizPassedWebSocketListener
{
    public function handle($eventPayload)
    {
        $studentId = $eventPayload[0];
        $lessonId = $eventPayload[1];

        $course = DB::table('lessons')
            ->join('courses', 'lessons.course_id', '=', 'courses.id')
            ->where('lessons.id', $lessonId)
            ->select('courses.title', 'courses.instructor_id')
            ->first();

        if ($course) {
            event(new LiveNotificationEvent(
                $course->instructor_id,
                "A student has successfully passed the quiz for your lesson!",
                ['course_title' => $course->title, 'student_id' => $studentId]
            ));

            event(new LiveNotificationEvent(
                $studentId,
                "Congratulations! You passed the quiz for " . $course->title,
                ['lesson_id' => $lessonId]
            ));
        }
    }
}

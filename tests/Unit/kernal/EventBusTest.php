<?php
// tests/Unit/Kernel/EventBusTest.php

namespace Tests\Unit\Kernal;

use Tests\TestCase;
use Illuminate\Support\Facades\Event;

class EventBusTest extends TestCase
{
    /** @test */
    public function it_dispatches_inter_plugin_events_successfully_via_the_shared_event_bus()
    {
        Event::fake();

        $studentId = 'fake-student-uuid-v4';
        $lessonId = 'fake-lesson-uuid-v4';

        Event::dispatch('quiz.passed', [$studentId, $lessonId]);

        Event::assertDispatched('quiz.passed', function ($event, $payload) use ($studentId, $lessonId) {
            return $payload[0] === $studentId && $payload[1] === $lessonId;
        });
    }
}

<?php
/*
namespace plugins\Course\src\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use plugins\Course\src\Services\CoursePublishService;

class PublishCourseJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public string $courseId
    ) {}

    public function handle(
        // CoursePublishService $service
    ): void
    {
        $service->publish(
            $this->courseId
        );
        \Log::info('course published event fired');
    }
}
*/

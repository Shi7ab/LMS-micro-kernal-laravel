<?php
namespace Plugins\Notifications\src;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use plugins\Course\src\Events\CoursePublished;

class NotificationsPluginServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Listen to the shared event bus message silently
        Event::listen('enrollment.created', function (array $payload) {

            // Persist the in-app notification context layout securely using parameterized execution
            DB::table('notifications')->insert([
                'id' => (string) Str::uuid(),
                'user_id' => $payload['student_id'],
                'message' => "Welcome! You have been successfully enrolled in course: " . $payload['course_id'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        });

       /* Event::listen(CoursePublished::class,
        function (){
            log('course published successfully !');
        }
        );*/

        Event::listen('course.published', function(){
            log('course published successfully !');
        });


    }
}

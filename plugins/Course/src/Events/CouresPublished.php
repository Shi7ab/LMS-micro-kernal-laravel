<?php

namespace plugins\Course\src\Events;

use plugins\Course\src\Models\Course;

class CoursePublished
{
    public function __construct(
        public Course $course
    ) {
    }
}

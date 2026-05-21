<?php

namespace Plugins\Enrollment\src\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EnrollmentCreated
{
    use Dispatchable, SerializesModels;

    public array $data;

    
    public function __construct(array $data)
    {
        $this->data = $data;
    }
}

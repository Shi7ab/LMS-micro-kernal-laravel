<?php

namespace plugins\Course\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Course extends Model
{
    use HasUuids;

    protected $table = 'courses';

    protected $fillable = [

        'title',

        'description',

        'status',

        'instructor_id'
    ];

    /*
    |--------------------------------------------------------------------------
    | UUID Configuration
    |--------------------------------------------------------------------------
    */

    public function lessons()
    {
        return $this->hasMany(
            Lesson::class,
            'course_id'
        );
    }
    
    public $incrementing = false;

    protected $keyType = 'string';

}

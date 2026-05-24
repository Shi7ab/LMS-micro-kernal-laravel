<?php

namespace plugins\Course\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lesson extends Model
{
    protected $table = 'lessons';

    protected $fillable = [
        'id',
        'course_id',
        'title',
        'content',
        'sort_order',
    ];

    /*
    |--------------------------------------------------------------------------
    | UUID Configuration
    |--------------------------------------------------------------------------
    */

    public $incrementing = false;

    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lesson) {

            if (!$lesson->id) {
                $lesson->id = (string) Str::uuid();
            }
        });
    }
}

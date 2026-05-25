<?php

namespace plugins\Course\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Lesson extends Model
{
    protected $table = 'lessons';

    use HasUuids;
    protected $fillable = [

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

  public function course()
  {
        return $this->belongsTo(
            Course::class,
            'course_id'
        );
  }
}

<?php

namespace plugins\Media\src\Models;

use Illuminate\Database\Eloquent\Model;

class LessonMedia extends Model
{
    protected $table = 'lesson_media';

    protected $fillable = [
        'lesson_id',
        'file_name',
        'file_path',
        'file_type',
        'size_in_bytes',
    ];
}

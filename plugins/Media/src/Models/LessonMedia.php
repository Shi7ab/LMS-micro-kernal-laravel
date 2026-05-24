<?php
// plugins/Media/src/Models/LessonMedia.php

namespace Plugins\Media\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class LessonMedia extends Model
{
    use HasUuids;

    protected $table = 'lesson_media';

    protected $fillable = [
        'lesson_id',
        'file_name',
        'file_path',
        'file_type',
        'size_in_bytes'
    ];
}

<?php
// plugins/Progress/src/Models/LessonProgress.php
namespace plugins\Progress\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class LessonProgress extends Model
{
    use HasUuids;
    protected $table = 'student_lesson_progress';
    public $timestamps = false;
    protected $fillable = ['student_id', 'lesson_id'];
}

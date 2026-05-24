<?php
// plugins/Courses/src/Models/Lesson.php
namespace plugins\Course\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Lesson extends Model
{
    use HasUuids;
    protected $fillable = ['course_id', 'title', 'content', 'sort_order'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}

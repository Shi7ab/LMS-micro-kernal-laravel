<?php
// plugins/Courses/src/Models/Course.php
namespace plugins\Course\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Course extends Model
{
    use HasUuids;
    protected $fillable = ['instructor_id', 'title', 'description', 'status'];

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('sort_order', 'asc');
    }
}

<?php
namespace plugins\Quiz\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class QuizAttempt extends Model
{
    use HasUuids;
    protected $table = 'quiz_attempts';
    protected $fillable = ['student_id', 'quiz_id', 'score', 'is_passed'];
}

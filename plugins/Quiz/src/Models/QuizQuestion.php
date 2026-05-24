<?php
namespace Plugins\Quiz\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class QuizQuestion extends Model
{
    use HasUuids;
    protected $table = 'quiz_questions';
    protected $fillable = ['quiz_id', 'question_text', 'options', 'correct_option'];


    protected $casts = [
        'options' => 'array'
    ];
}

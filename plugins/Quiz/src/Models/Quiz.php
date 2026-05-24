<?php
// plugins/Quiz/src/Models/Quiz.php
namespace Plugins\Quiz\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Quiz extends Model
{
    use HasUuids;
    protected $fillable = ['lesson_id', 'title', 'passing_score'];

    public function questions() {
        return $this->hasMany(QuizQuestion::class);
    }
}

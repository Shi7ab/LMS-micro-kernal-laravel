<?php
// plugins/Quiz/src/Http/Controllers/QuizController.php
namespace plugins\Quiz\src\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use plugins\Quiz\src\Models\Quiz;
use plugins\Quiz\src\Models\QuizQuestion;
use plugins\Quiz\src\Models\QuizAttempt;
use Illuminate\Support\Facades\Event;

class QuizController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lesson_id' => 'required|uuid',
            'title' => 'required|string|max:255',
            'passing_score' => 'required|integer|min:1|max:100',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.options' => 'required|array',
            'questions.*.correct_option' => 'required|string',
        ]);

        $quiz = Quiz::create([
            'lesson_id' => $validated['lesson_id'],
            'title' => $validated['title'],
            'passing_score' => $validated['passing_score']
        ]);

        foreach ($validated['questions'] as $q) {
            $quiz->questions()->create([
                'question_text' => $q['question_text'],
                'options' => $q['options'],
                'correct_option' => $q['correct_option']
            ]);
        }

        return response()->json(['status' => 'success', 'data' => $quiz->load('questions')], 201);
    }


    public function submit(Request $request, $quizId)
    {
        $quiz = Quiz::with('questions')->findOrFail($quizId);
        $studentId = $request->attributes->get('user_id');
        $validated = $request->validate([
            'answers' => 'required|array',
        ]);

        $totalQuestions = $quiz->questions->count();
        $correctAnswersCount = 0;

        foreach ($quiz->questions as $question) {
            $studentAnswer = $validated['answers'][$question->id] ?? null;
            if ($studentAnswer === $question->correct_option) {
                $correctAnswersCount++;
            }
        }

        $score = ($totalQuestions > 0) ? ($correctAnswersCount / $totalQuestions) * 100 : 0;
        $isPassed = $score >= $quiz->passing_score;

        $attempt = QuizAttempt::create([
            'student_id' => $studentId,
            'quiz_id' => $quiz->id,
            'score' => $score,
            'is_passed' => $isPassed
        ]);

        if ($isPassed) {
            Event::dispatch('quiz.passed', [$studentId, $quiz->lesson_id]);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'attempt_id' => $attempt->id,
                'score' => $score . '%',
                'is_passed' => $isPassed,
                'correct_answers' => $correctAnswersCount . '/' . $totalQuestions
            ]
        ]);
    }
}

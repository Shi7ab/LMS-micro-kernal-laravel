<?php
// plugins/Quiz/src/Http/Controllers/QuizController.php
namespace plugins\Quiz\src\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use plugins\Quiz\src\Models\Quiz;
use plugins\Quiz\src\Models\QuizQuestion;
use plugins\Quiz\src\Models\QuizAttempt;
use Illuminate\Support\Facades\Event;
use plugins\Quiz\src\Services\QuizService;

class QuizController extends Controller
{
    /*
    protected $service;
    public function __contruct(QuizService $service){
      $this->service = $service;
    }*/

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
        // creating the quiz
        $quiz = Quiz::create([
            'lesson_id' => $validated['lesson_id'],
            'title' => $validated['title'],
            'passing_score' => $validated['passing_score']
        ]);
        // create question in the quiz
        foreach ($validated['questions'] as $q) {
            $quiz->questions()->create([
                'question_text' => $q['question_text'],
                'options' => $q['options'],
                'correct_option' => $q['correct_option']
            ]);
        }

         //   $quiz =  $service->create($validated);

        return response()->json(['status' => 'success', 'data' => $quiz->load('questions')], 201);
    }


    public function submit(Request $request, $quizId)
    {  // submiting questuin and validate the answer
       //$quiz = Quiz::with('questions')->findOrFail($quizId);
        // $studentId = $request->attributes->get('user_id');
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
        // creating the attrmpts and fire event is passed
        $attempt = QuizAttempt::create([
            'student_id' => $studentId,
            'quiz_id' => $quiz->id,
            'score' => $score,
            'is_passed' => $isPassed
        ]);

        if ($isPassed) {
            Event::dispatch('quiz.passed', [$studentId, $quiz->lesson_id]);
        }

      //  $quiz = $service->submit($quizId);
        return response()->json([
            'status' => 'success',
            'data' => [
                'attempt_id' => $attempt->id,
                'score' => $score . '%',
                'is_passed' => $isPassed,
                'correct_answers' => $correctAnswersCount . '/' . $totalQuestions
            ]
        ]);
        return $quiz;
    }
}

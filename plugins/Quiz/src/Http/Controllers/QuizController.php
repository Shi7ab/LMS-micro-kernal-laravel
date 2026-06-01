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
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{

     public function __construct(
        protected QuizService $service
    ) {}

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

        $quiz =  $service->create($validated);

        return response()->json(['status' => 'success', 'data' => $quiz->load('questions')], 201);
    }


    public function submit(Request $request, $quizId)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
        ]);
     
         $result = $this->service->submit(
            $quizId,
            Auth::id(),
            $validated['answers']
        );

        return response()->json([
            'status' => 'success',
            'data' => $result
        ]);
    }
}

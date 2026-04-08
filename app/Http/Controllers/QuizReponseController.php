<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Note;
use Illuminate\Http\Request;

class QuizReponseController extends Controller
{
    /**
     * Show the form for answering a quiz (Apprenant only).
     */
    public function create(Quiz $quiz)
    {
        $quiz->load('questions.reponses');

        return view('apprenant.quiz.repondre', compact('quiz'));
    }

    /**
     * Store the quiz responses and calculate the score (Apprenant only).
     */
    public function store(Request $request, Quiz $quiz)
    {

        $user = auth()->user();

        // Validate the responses
        $request->validate([
            'responses' => 'required|array',
            'responses.*' => 'required|integer|exists:reponses,id',
        ]);

        // Calculate the score
        $score = $this->calculateScore($quiz, $request->responses);

        // Store the note
        $note = Note::updateOrCreate(
            [
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
            ],
            [
                'note_sur_20' => $score,
            ]
        );

        return redirect()
            ->route('apprenant.quiz.show', $quiz)
            ->with('success', "Quiz complété ! Votre note : {$score}/20");
    }

    /**
     * Calculate the score for the quiz responses.
     */
    private function calculateScore(Quiz $quiz, array $responses): float
    {
        $totalQuestions = $quiz->questions()->count();

        if ($totalQuestions === 0) {
            return 0;
        }

        $correctAnswers = 0;

        foreach ($quiz->questions as $question) {
            if (isset($responses[$question->id])) {
                $selectedReponsId = $responses[$question->id];

                // Check if the response is correct
                $reponse = $question->reponses()
                    ->where('id', $selectedReponsId)
                    ->first();

                if ($reponse && $reponse->est_correcte) {
                    $correctAnswers++;
                }
            }
        }

        // Convert to score out of 20
        $score = ($correctAnswers / $totalQuestions) * 20;

        return round($score, 2);
    }

    /**
     * Display the quiz results.
     */
    public function results(Quiz $quiz)
    {
        $user = auth()->user();
        $note = $user->notes()
            ->where('quiz_id', $quiz->id)
            ->first();

        if (!$note) {
            return redirect()->route('apprenant.quiz.show', $quiz)
                ->with('error', 'Aucun résultat trouvé pour ce quiz.');
        }

        return view('apprenant.quiz.resultats', compact('quiz', 'note'));
    }
}

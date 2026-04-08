<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of all questions (Admin only).
     */
    public function index(Request $request)
    {
        $questions = Question::with('quiz')->paginate(10);

        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new question (Admin only).
     */
    public function create()
    {
        $quizzes = Quiz::all();

        return view('questions.create', compact('quizzes'));
    }

    /**
     * Store a newly created question (Admin only).
     */
    public function store(StoreQuestionRequest $request)
    {
        $question = Question::create($request->validated());

        return redirect()
            ->route('admin.questions.show', $question)
            ->with('success', 'Question créée avec succès !');
    }

    /**
     * Display the specified question with its answers.
     */
    public function show(Question $question)
    {
        $question->load(['quiz', 'reponses']);

        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified question (Admin only).
     */
    public function edit(Question $question)
    {
        $quizzes = Quiz::all();

        return view('questions.edit', compact('question', 'quizzes'));
    }

    /**
     * Update the specified question (Admin only).
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $question->update($request->validated());

        return redirect()
            ->route('admin.questions.show', $question)
            ->with('success', 'Question mise à jour avec succès !');
    }

    /**
     * Remove the specified question (Admin only).
     */
    public function destroy(Question $question)
    {
        $quiz = $question->quiz;
        $question->delete();

        return redirect()
            ->route('admin.quiz.show', $quiz)
            ->with('success', 'Question supprimée avec succès !');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\SousChapitre;
use App\Models\Chapitre;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of all quizzes (Admin only).
     */
    public function index(Request $request)
    {
        $quizzes = Quiz::with('sousChapitre')->paginate(10);

        return view('quiz.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new quiz (Admin only).
     */
    public function create()
    {
        $sousChapitres = SousChapitre::all();

        return view('quiz.create', compact('sousChapitres'));
    }

    /**
     * Store a newly created quiz (Admin only).
     */
    public function store(StoreQuizRequest $request)
    {
        $quiz = Quiz::create($request->validated());

        return redirect()
            ->route('admin.quiz.show', $quiz)
            ->with('success', 'Quiz créé avec succès !');
    }

    /**
     * Display the specified quiz with its questions.
     */
    public function show(Quiz $quiz)
    {
        $quiz->load(['questions.reponses', 'sousChapitre']);

        return view('quiz.show', compact('quiz'));
    }

    /**
     * Display the specified quiz for learners with questions and answers (Apprenant only).
     */
    public function showApprenant(Quiz $quiz)
    {
        // Verify that the quiz belongs to the user's formation
        $user = auth()->user();
        $sousChapitre = $quiz->sousChapitre;

        if ($sousChapitre->chapitre->formation_id != $user->formation_id) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Accès refusé à ce quiz.');
        }

        $quiz->load([
            'questions' => function ($query) {
                $query->with('reponses');
            },
            'sousChapitre'
        ]);

        return view('apprenant.quiz.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified quiz (Admin only).
     */
    public function edit(Quiz $quiz)
    {
        $sousChapitres = SousChapitre::all();

        return view('quiz.edit', compact('quiz', 'sousChapitres'));
    }

    /**
     * Update the specified quiz (Admin only).
     */
    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        $quiz->update($request->validated());

        return redirect()
            ->route('admin.quiz.show', $quiz)
            ->with('success', 'Quiz mise à jour avec succès !');
    }

    /**
     * Remove the specified quiz (Admin only).
     */
    public function destroy(Quiz $quiz)
    {
        $titre = $quiz->titre;
        $sousChapitre = $quiz->sousChapitre;
        $quiz->delete();

        return redirect()
            ->route('admin.sous-chapitres.show', $sousChapitre)
            ->with('success', "Quiz '{$titre}' supprimé avec succès !");
    }

    /**
     * Display all quizzes for a specific chapitre.
     */
    public function indexByChapitre(Chapitre $chapitre, Request $request)
    {
        $quizzes = Quiz::whereIn('sous_chapitre_id', $chapitre->sousChapitres->pluck('id'))
            ->with('questions')
            ->paginate(10);

        return view('apprenant.quiz.index', compact('chapitre', 'quizzes'));
    }
}

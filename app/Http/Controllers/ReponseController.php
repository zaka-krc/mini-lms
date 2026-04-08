<?php

namespace App\Http\Controllers;

use App\Models\Reponse;
use App\Models\Question;
use App\Http\Requests\StoreReponseRequest;
use App\Http\Requests\UpdateReponseRequest;
use Illuminate\Http\Request;

class ReponseController extends Controller
{
    /**
     * Display a listing of all reponses (Admin only).
     */
    public function index(Request $request)
    {
        $reponses = Reponse::with('question')->paginate(10);

        return view('reponses.index', compact('reponses'));
    }

    /**
     * Show the form for creating a new reponse (Admin only).
     */
    public function create()
    {
        $questions = Question::all();

        return view('reponses.create', compact('questions'));
    }

    /**
     * Store a newly created reponse (Admin only).
     */
    public function store(StoreReponseRequest $request)
    {
        $reponse = Reponse::create($request->validated());

        return redirect()
            ->route('admin.reponses.show', $reponse)
            ->with('success', 'Réponse créée avec succès !');
    }

    /**
     * Display the specified reponse.
     */
    public function show(Reponse $reponse)
    {
        $reponse->load('question');

        return view('reponses.show', compact('reponse'));
    }

    /**
     * Show the form for editing the specified reponse (Admin only).
     */
    public function edit(Reponse $reponse)
    {
        $questions = Question::all();

        return view('reponses.edit', compact('reponse', 'questions'));
    }

    /**
     * Update the specified reponse (Admin only).
     */
    public function update(UpdateReponseRequest $request, Reponse $reponse)
    {
        $reponse->update($request->validated());

        return redirect()
            ->route('admin.reponses.show', $reponse)
            ->with('success', 'Réponse mise à jour avec succès !');
    }

    /**
     * Remove the specified reponse (Admin only).
     */
    public function destroy(Reponse $reponse)
    {
        $question = $reponse->question;
        $reponse->delete();

        return redirect()
            ->route('admin.questions.show', $question)
            ->with('success', 'Réponse supprimée avec succès !');
    }
}

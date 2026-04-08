<?php

namespace App\Http\Controllers;

use App\Models\SousChapitre;
use App\Models\Chapitre;
use App\Http\Requests\StoreSousChapitreRequest;
use App\Http\Requests\UpdateSousChapitreRequest;
use Illuminate\Http\Request;

class SousChapitreController extends Controller
{
    /**
     * Display a listing of all sous-chapitres (Admin only).
     */
    public function index(Request $request)
    {
        $sousChapitres = SousChapitre::with('chapitre')->paginate(10);

        return view('sous-chapitres.index', compact('sousChapitres'));
    }

    /**
     * Show the form for creating a new sous-chapitre (Admin only).
     */
    public function create()
    {
        $chapitres = Chapitre::all();

        return view('sous-chapitres.create', compact('chapitres'));
    }

    /**
     * Store a newly created sous-chapitre (Admin only).
     */
    public function store(StoreSousChapitreRequest $request)
    {
        $sousChapitre = SousChapitre::create($request->validated());

        return redirect()
            ->route('admin.sous-chapitres.show', $sousChapitre)
            ->with('success', 'Sous-chapitre créé avec succès !');
    }

    /**
     * Display the specified sous-chapitre.
     */
    public function show(SousChapitre $sousChapitre)
    {
        $sousChapitre->load(['chapitre', 'quizzes']);

        return view('sous-chapitres.show', compact('sousChapitre'));
    }

    /**
     * Display the specified sous-chapitre for learners with quiz details (Apprenant only).
     */
    public function showApprenant(SousChapitre $sousChapitre)
    {
        // Verify that the sous-chapitre belongs to the user's formation
        $user = auth()->user();
        if ($sousChapitre->chapitre->formation_id != $user->formation_id) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Accès refusé à ce sous-chapitre.');
        }

        $sousChapitre->load([
            'chapitre',
            'quizzes' => function ($query) {
                $query->with('questions.reponses');
            }
        ]);

        return view('apprenant.sous-chapitres.show', compact('sousChapitre'));
    }

    /**
     * Show the form for editing the specified sous-chapitre (Admin only).
     */
    public function edit(SousChapitre $sousChapitre)
    {
        $chapitres = Chapitre::all();

        return view('sous-chapitres.edit', compact('sousChapitre', 'chapitres'));
    }

    /**
     * Update the specified sous-chapitre (Admin only).
     */
    public function update(UpdateSousChapitreRequest $request, SousChapitre $sousChapitre)
    {
        $sousChapitre->update($request->validated());

        return redirect()
            ->route('admin.sous-chapitres.show', $sousChapitre)
            ->with('success', 'Sous-chapitre mise à jour avec succès !');
    }

    /**
     * Remove the specified sous-chapitre (Admin only).
     */
    public function destroy(SousChapitre $sousChapitre)
    {
        $titre = $sousChapitre->titre;
        $chapitre = $sousChapitre->chapitre;
        $sousChapitre->delete();

        return redirect()
            ->route('admin.chapitres.show', $chapitre)
            ->with('success', "Sous-chapitre '{$titre}' supprimé avec succès !");
    }

    /**
     * Display all sous-chapitres for a specific chapitre.
     */
    public function indexByCharpitre(Chapitre $chapitre, Request $request)
    {
        $sousChapitres = $chapitre->sousChapitres()
            ->with('quizzes')
            ->orderBy('ordre')
            ->paginate(10);

        return view('apprenant.sous-chapitres.index', compact('chapitre', 'sousChapitres'));
    }

    /**
     * Display all sous-chapitres for a specific chapitre (Apprenant only).
     */
    public function indexByChapitreApprenant(Chapitre $chapitre, Request $request)
    {
        // Verify that the chapter belongs to the user's formation
        $user = auth()->user();
        if ($chapitre->formation_id != $user->formation_id) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Accès refusé à ce chapitre.');
        }

        $sousChapitres = $chapitre->sousChapitres()
            ->with('quizzes')
            ->orderBy('ordre')
            ->paginate(10);

        return view('apprenant.sous-chapitres.index', compact('chapitre', 'sousChapitres'));
    }
}

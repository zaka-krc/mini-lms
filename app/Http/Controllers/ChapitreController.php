<?php

namespace App\Http\Controllers;

use App\Models\Chapitre;
use App\Models\Formation;
use App\Http\Requests\StoreChapitreRequest;
use App\Http\Requests\UpdateChapitreRequest;
use Illuminate\Http\Request;

class ChapitreController extends Controller
{
    /**
     * Display a listing of all chapitres (Admin only).
     */
    public function index(Request $request)
    {
        $chapitres = Chapitre::with('formation')->paginate(10);

        return view('chapitres.index', compact('chapitres'));
    }

    /**
     * Show the form for creating a new chapitre (Admin only).
     */
    public function create()
    {
        $formations = Formation::all();

        return view('chapitres.create', compact('formations'));
    }

    /**
     * Store a newly created chapitre (Admin only).
     */
    public function store(StoreChapitreRequest $request)
    {
        $chapitre = Chapitre::create($request->validated());

        return redirect()
            ->route('admin.chapitres.show', $chapitre)
            ->with('success', 'Chapitre créé avec succès !');
    }

    /**
     * Display the specified chapitre (Admin only).
     */
    public function show(Chapitre $chapitre)
    {
        $chapitre->load(['formation', 'sousChapitres']);

        return view('admin.chapitres.show', compact('chapitre'));
    }

    /**
     * Display the specified chapitre for learners (Apprenant only).
     */
    public function showApprenant(Chapitre $chapitre)
    {
        $user = auth()->user();
        if ($chapitre->formation_id != $user->formation_id) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Accès refusé à ce chapitre.');
        }

        $chapitre->load(['formation.chapitres', 'sousChapitres.quizzes']);

        return view('apprenant.chapitres.show', compact('chapitre'));
    }

    /**
     * Show the form for editing the specified chapitre (Admin only).
     */
    public function edit(Chapitre $chapitre)
    {
        $formations = Formation::all();

        return view('chapitres.edit', compact('chapitre', 'formations'));
    }

    /**
     * Update the specified chapitre (Admin only).
     */
    public function update(UpdateChapitreRequest $request, Chapitre $chapitre)
    {
        $chapitre->update($request->validated());

        return redirect()
            ->route('admin.chapitres.show', $chapitre)
            ->with('success', 'Chapitre mise à jour avec succès !');
    }

    /**
     * Remove the specified chapitre (Admin only).
     */
    public function destroy(Chapitre $chapitre)
    {
        $titre = $chapitre->titre;
        $chapitre->delete();

        return redirect()
            ->route('admin.chapitres.index')
            ->with('success', "Chapitre '{$titre}' supprimé avec succès !");
    }

    /**
     * Display all chapitres for a specific formation.
     */
    public function indexByFormation(Formation $formation, Request $request)
    {
        $chapitres = $formation->chapitres()
            ->with('sousChapitres')
            ->orderBy('ordre')
            ->paginate(10);

        return view('apprenant.chapitres.index', compact('formation', 'chapitres'));
    }

    /**
     * Display all sous-chapitres for a specific chapitre (Apprenant only).
     */
    public function indexByChapitre(Chapitre $chapitre, Request $request)
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

    /**
     * Display all chapitres from the user's formation (Apprenant only).
     */
    public function indexFormationApprenante(Request $request)
    {
        $user = auth()->user();
        $formation = $user->formation()->first();

        if (!$formation) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Vous n\'êtes inscrit à aucune formation.');
        }

        $chapitres = $formation->chapitres()
            ->with('sousChapitres')
            ->orderBy('ordre')
            ->paginate(10);

        return view('apprenant.chapitres.formation-apprenante', compact('formation', 'chapitres'));
    }
}

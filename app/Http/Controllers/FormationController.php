<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\User;
use App\Http\Requests\StoreFormationRequest;
use App\Http\Requests\UpdateFormationRequest;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    /**
     * Display a listing of all formations (Admin only).
     */
    public function index(Request $request)
    {
        $formations = Formation::paginate(10);

        return view('formations.index', compact('formations'));
    }

    /**
     * Show the form for creating a new formation (Admin only).
     */
    public function create()
    {
        return view('formations.create');
    }

    /**
     * Store a newly created formation (Admin only).
     */
    public function store(StoreFormationRequest $request)
    {
        $formation = Formation::create($request->validated());

        return redirect()
            ->route('admin.formations.show', $formation)
            ->with('success', 'Formation créée avec succès !');
    }

    /**
     * Display the specified formation.
     */
    public function show(Formation $formation)
    {
        $apprenantsSansFormation = User::where('role', 'apprenant')
            ->whereNull('formation_id')
            ->orderBy('name')
            ->get();

        return view('formations.show', compact('formation', 'apprenantsSansFormation'));
    }

    /**
     * Assign an apprenant to this formation (Admin only).
     */
    public function assignApprenant(Request $request, Formation $formation)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->update(['formation_id' => $formation->id]);

        return back()->with('success', "{$user->name} a été inscrit à la formation.");
    }

    /**
     * Remove an apprenant from this formation (Admin only).
     */
    public function retirerApprenant(Formation $formation, User $user)
    {
        $user->update(['formation_id' => null]);

        return back()->with('success', "{$user->name} a été retiré de la formation.");
    }

    /**
     * Show the form for editing the specified formation (Admin only).
     */
    public function edit(Formation $formation)
    {
        return view('formations.edit', compact('formation'));
    }

    /**
     * Update the specified formation (Admin only).
     */
    public function update(UpdateFormationRequest $request, Formation $formation)
    {
        $formation->update($request->validated());

        return redirect()
            ->route('admin.formations.show', $formation)
            ->with('success', 'Formation mise à jour avec succès !');
    }

    /**
     * Remove the specified formation (Admin only).
     */
    public function destroy(Formation $formation)
    {
        $nom = $formation->nom;
        $formation->delete();

        return redirect()
            ->route('admin.formations.index')
            ->with('success', "Formation '{$nom}' supprimée avec succès !");
    }

    /**
     * Allow an apprenant to self-enroll in a formation.
     */
    public function choisirFormation(Request $request)
    {
        $request->validate([
            'formation_id' => 'required|exists:formations,id',
        ]);

        auth()->user()->update(['formation_id' => $request->formation_id]);

        return redirect()->route('dashboard')->with('success', 'Vous êtes maintenant inscrit à la formation !');
    }

    /**
     * Display formations for learners (Apprenant only).
     */
    public function mesFomations()
    {
        $user = auth()->user();
        $formations = Formation::where('id', $user->formation_id)->paginate(10);

        return view('apprenant.formations.index', compact('formations'));
    }

    /**
     * Display the user's formation with its chapitres (Apprenant only).
     */
    public function maFormation()
    {
        $user = auth()->user();
        $formation = $user->formation()->with('chapitres')->first();

        if (!$formation) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Vous n\'êtes inscrit à aucune formation.');
        }

        $formation->load(['chapitres' => function ($query) {
            $query->orderBy('ordre')->with('sousChapitres');
        }]);

        return view('apprenant.formations.maformation', compact('formation'));
    }
}

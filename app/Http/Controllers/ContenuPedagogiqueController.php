<?php

namespace App\Http\Controllers;

use App\Models\ContenuPedagogique;
use App\Models\SousChapitre;
use Illuminate\Http\Request;

class ContenuPedagogiqueController extends Controller
{
    public function index()
    {
        $contenus = ContenuPedagogique::with('sousChapitre.chapitre.formation')->latest()->paginate(20);
        return view('admin.contenus.index', compact('contenus'));
    }

    public function create(Request $request)
    {
        $sousChapitres = SousChapitre::with('chapitre.formation')->orderBy('titre')->get();
        $selectedSousChapitreId = $request->query('sous_chapitre_id');
        return view('admin.contenus.create', compact('sousChapitres', 'selectedSousChapitreId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'            => 'required|string|max:255',
            'texte'            => 'nullable|string',
            'lien_ressource'   => 'nullable|url|max:500',
            'sous_chapitre_id' => 'required|exists:sous_chapitres,id',
        ]);

        $contenu = ContenuPedagogique::create($validated);

        return redirect()
            ->route('admin.contenus.show', $contenu)
            ->with('success', 'Contenu pédagogique créé avec succès !');
    }

    public function show(ContenuPedagogique $contenu)
    {
        $contenu->load('sousChapitre.chapitre.formation');
        return view('admin.contenus.show', compact('contenu'));
    }

    public function edit(ContenuPedagogique $contenu)
    {
        $sousChapitres = SousChapitre::with('chapitre.formation')->orderBy('titre')->get();
        return view('admin.contenus.edit', compact('contenu', 'sousChapitres'));
    }

    public function update(Request $request, ContenuPedagogique $contenu)
    {
        $validated = $request->validate([
            'titre'            => 'required|string|max:255',
            'texte'            => 'nullable|string',
            'lien_ressource'   => 'nullable|url|max:500',
            'sous_chapitre_id' => 'required|exists:sous_chapitres,id',
        ]);

        $contenu->update($validated);

        return redirect()
            ->route('admin.contenus.show', $contenu)
            ->with('success', 'Contenu pédagogique mis à jour avec succès !');
    }

    public function destroy(ContenuPedagogique $contenu)
    {
        $titre = $contenu->titre;
        $contenu->delete();

        return redirect()
            ->route('admin.contenus.index')
            ->with('success', "Contenu \"{$titre}\" supprimé avec succès !");
    }

    /**
     * Show a contenu for an apprenant.
     */
    public function showApprenant(ContenuPedagogique $contenu)
    {
        $contenu->load('sousChapitre.chapitre.formation');
        return view('apprenant.contenus.show', compact('contenu'));
    }
}

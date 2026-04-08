<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Formation;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $notes = Note::with(['user', 'quiz'])->latest()->paginate(15);

        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        $apprenants = User::where('role', 'apprenant')->get();
        $quizzes = Quiz::with('sousChapitre')->get();

        return view('notes.create', compact('apprenants', 'quizzes'));
    }

    public function store(StoreNoteRequest $request)
    {
        $note = Note::updateOrCreate(
            ['user_id' => $request->user_id, 'quiz_id' => $request->quiz_id],
            ['note_sur_20' => $request->note_sur_20]
        );

        return redirect()
            ->route('admin.notes.show', $note)
            ->with('success', 'Note créée avec succès !');
    }

    public function show(Note $note)
    {
        $note->load(['user', 'quiz.sousChapitre.chapitre.formation']);

        return view('notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        $apprenants = User::where('role', 'apprenant')->get();
        $quizzes = Quiz::with('sousChapitre')->get();

        return view('notes.edit', compact('note', 'apprenants', 'quizzes'));
    }

    public function update(UpdateNoteRequest $request, Note $note)
    {
        $note->update($request->validated());

        return redirect()
            ->route('admin.notes.show', $note)
            ->with('success', 'Note mise à jour avec succès !');
    }

    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()
            ->route('admin.notes.index')
            ->with('success', 'Note supprimée avec succès !');
    }

    public function mesNotes()
    {
        $user = auth()->user();
        $notes = $user->notes()->with('quiz')->latest()->paginate(15);

        return view('apprenant.notes.index', compact('notes'));
    }

    public function notesApprenant(User $user)
    {
        if ($user->role !== 'apprenant') {
            return redirect()->route('admin.notes.index')->with('error', 'Cet utilisateur n\'est pas un apprenant.');
        }

        $apprenants = User::where('role', 'apprenant')->get();
        $notes = $user->notes()->with('quiz')->latest()->paginate(15);

        return view('notes.apprenant', compact('user', 'notes', 'apprenants'));
    }

    public function notesByFormation(Request $request)
    {
        $formations = Formation::all();
        $formationId = $request->query('formation_id');

        $query = Note::with(['user', 'quiz'])->latest();

        if ($formationId) {
            $formation = Formation::findOrFail($formationId);
            $query->whereIn('user_id', $formation->users()->pluck('id'));
        }

        $notes = $query->paginate(15);

        return view('notes.by-formation', compact('formations', 'notes'));
    }

    public function indexByFormation(Formation $formation, Request $request)
    {
        $formations = Formation::all();

        $notes = Note::whereIn('user_id', $formation->users()->pluck('id'))
            ->with(['user', 'quiz'])
            ->latest()
            ->paginate(15);

        return view('notes.by-formation', compact('formations', 'notes'));
    }
}

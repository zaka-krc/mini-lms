<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\ChapitreController;
use App\Http\Controllers\SousChapitreController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReponseController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\QuizReponseController;
use App\Http\Controllers\ContenuPedagogiqueController;
use Illuminate\Support\Facades\Route;

// ========== ROUTES PUBLIQUES ==========
Route::get('/', function () {
    $formations = \App\Models\Formation::withCount('chapitres')->latest()->get();
    $stats = [
        'formations' => \App\Models\Formation::count(),
        'apprenants' => \App\Models\User::where('role', 'apprenant')->count(),
        'quiz'       => \App\Models\Quiz::count(),
    ];
    return view('welcome', compact('formations', 'stats'));
})->name('home');

// ========== ROUTES AUTHENTIFIÉES ==========
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard - redirection selon le rôle
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Routes de profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ========== ROUTES APPRENANTS ==========
    Route::middleware('role:apprenant')->group(function () {

        // S'inscrire soi-même à une formation
        Route::post('/choisir-formation', [FormationController::class, 'choisirFormation'])->name('apprenant.choisirFormation');

        // Consulter sa formation
        Route::get('/ma-formation', [FormationController::class, 'maFormation'])->name('apprenant.formation.show');
        
        // Consulter les chapitres de sa formation
        Route::get('/formation/chapitres', [ChapitreController::class, 'indexFormationApprenante'])->name('apprenant.chapitres.index');
        Route::get('/chapitre/{chapitre}', [ChapitreController::class, 'showApprenant'])->name('apprenant.chapitre.show');

        // Consulter les sous-chapitres
        Route::get('/chapitre/{chapitre}/sous-chapitres', [SousChapitreController::class, 'indexByChapitreApprenant'])->name('apprenant.sous-chapitres.index');
        Route::get('/sous-chapitre/{sousChapitre}', [SousChapitreController::class, 'showApprenant'])->name('apprenant.sous-chapitre.show');

        // Consulter et répondre aux quiz
        Route::get('/quiz/{quiz}', [QuizController::class, 'showApprenant'])->name('apprenant.quiz.show');
        Route::get('/quiz/{quiz}/repondre', [QuizReponseController::class, 'create'])->name('apprenant.quiz.repondre');
        Route::post('/quiz/{quiz}/repondre', [QuizReponseController::class, 'store'])->name('apprenant.quiz.repondre.store');

        // Contenus pédagogiques
        Route::get('/contenu/{contenu}', [ContenuPedagogiqueController::class, 'showApprenant'])->name('apprenant.contenu.show');

        // Mes notes
        Route::get('/mes-notes', [NoteController::class, 'mesNotes'])->name('apprenant.notes.index');
    });

    // ========== ROUTES ADMINS ==========
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        
        // RESSOURCES FORMATIONS
        Route::resource('formations', FormationController::class);

        // RESSOURCES CHAPITRES
        Route::resource('chapitres', ChapitreController::class);
        Route::get('formations/{formation}/chapitres', [ChapitreController::class, 'indexByFormation'])->name('chapitres.byFormation');

        // RESSOURCES SOUS-CHAPITRES
        Route::resource('sous-chapitres', SousChapitreController::class);
        Route::get('chapitres/{chapitre}/sous-chapitres', [SousChapitreController::class, 'indexByChapitre'])->name('sous-chapitres.byChapitre');

        // RESSOURCES QUIZ
        Route::resource('quiz', QuizController::class);
        Route::get('chapitres/{chapitre}/quiz', [QuizController::class, 'indexByChapitre'])->name('quiz.byChapitre');

        // RESSOURCES QUESTIONS
        Route::resource('questions', QuestionController::class);

        // RESSOURCES RÉPONSES
        Route::resource('reponses', ReponseController::class);

        // RESSOURCES NOTES
        Route::get('notes/by-formation', [NoteController::class, 'notesByFormation'])->name('notes.byFormation');
        Route::resource('notes', NoteController::class);
        Route::get('formations/{formation}/notes', [NoteController::class, 'indexByFormation'])->name('notes.byFormation.formation');

        // RESSOURCES CONTENUS PÉDAGOGIQUES
        Route::resource('contenus', ContenuPedagogiqueController::class);

        // ASSIGN APPRENANTS TO FORMATION
        Route::post('formations/{formation}/assigner', [FormationController::class, 'assignApprenant'])->name('formations.assignApprenant');
        Route::delete('formations/{formation}/retirer/{user}', [FormationController::class, 'retirerApprenant'])->name('formations.retirerApprenant');
    });
});

require __DIR__.'/auth.php';
<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display dashboard based on user role.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return $this->adminDashboard();
        }

        if ($user->role === 'apprenant') {
            return $this->apprenantDashboard($user);
        }

        return redirect()->route('home');
    }

    /**
     * Admin dashboard with statistics and overview.
     */
    private function adminDashboard()
    {
        $stats = [
            'formations' => Formation::count(),
            'total_users' => User::count(),
            'apprenants' => User::where('role', 'apprenant')->count(),
            'quiz' => Quiz::count(),
        ];

        $recentUsers = User::latest()->limit(5)->get();
        $recentFormations = Formation::latest()->limit(5)->get();

        return view('dashboard.admin', compact('stats', 'recentUsers', 'recentFormations'));
    }

    /**
     * Learner dashboard with their formations and notes.
     */
    private function apprenantDashboard(User $user)
    {
        $formation = $user->formation;

        if (!$formation) {
            $formations = Formation::withCount('chapitres')->orderBy('nom')->get();
            return view('dashboard.apprenant-no-formation', compact('formations'));
        }

        $chapitres = $formation->chapitres()
            ->with('sousChapitres')
            ->limit(5)
            ->get();

        $notes = $user->notes()->latest()->limit(5)->get();

        $progress = $this->calculateProgress($user, $formation);

        return view('dashboard.apprenant', compact('formation', 'chapitres', 'notes', 'progress'));
    }

    /**
     * Calculate the learner's progress in the formation.
     */
    private function calculateProgress(User $user, Formation $formation)
    {
        // Get all quizzes for this formation
        $totalQuizzes = Quiz::whereIn('sous_chapitre_id', 
            $formation->chapitres()
                ->with('sousChapitres')
                ->get()
                ->pluck('sousChapitres')
                ->flatten()
                ->pluck('id')
        )->count();

        if ($totalQuizzes === 0) {
            return 0;
        }

        // Get completed quizzes (quizzes with grades)
        $completedQuizzes = Note::where('user_id', $user->id)
            ->count();

        $percentage = ($completedQuizzes / $totalQuizzes) * 100;

        return min(round($percentage, 2), 100);
    }
}


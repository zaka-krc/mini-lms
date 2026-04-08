<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousChapitre extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'contenu',
        'chapitre_id',
        'ordre',
    ];

    /**
     * Get the chapitre that this sous-chapitre belongs to.
     */
    public function chapitre()
    {
        return $this->belongsTo(Chapitre::class);
    }

    /**
     * Get the quizzes for this sous-chapitre.
     */
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Get the contenus pédagogiques for this sous-chapitre.
     */
    public function contenusPedagogiques()
    {
        return $this->hasMany(ContenuPedagogique::class);
    }
}

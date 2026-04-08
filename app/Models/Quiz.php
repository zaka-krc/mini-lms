<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quiz';

    protected $fillable = [
        'titre',
        'sous_chapitre_id',
    ];

    /**
     * Get the sous-chapitre that this quiz belongs to.
     */
    public function sousChapitre()
    {
        return $this->belongsTo(SousChapitre::class, 'sous_chapitre_id');
    }

    /**
     * Get the questions for this quiz.
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get the notes for this quiz.
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}

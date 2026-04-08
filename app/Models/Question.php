<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'texte',
        'quiz_id',
    ];

    /**
     * Get the quiz that this question belongs to.
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the reponses for this question.
     */
    public function reponses()
    {
        return $this->hasMany(Reponse::class);
    }
}

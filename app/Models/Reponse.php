<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'texte',
        'est_correcte',
        'question_id',
    ];

    /**
     * Get the question that this reponse belongs to.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}

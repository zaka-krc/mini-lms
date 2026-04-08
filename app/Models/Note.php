<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'note_sur_20',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Alias pour la lisibilité dans les vues
    public function apprenant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}

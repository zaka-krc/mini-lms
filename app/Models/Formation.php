<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'niveau',
        'duree',
    ];

    /**
     * Get the chapitres for the formation.
     */
    public function chapitres()
    {
        return $this->hasMany(Chapitre::class);
    }

    /**
     * Get the users (apprenants) in this formation.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapitre extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'formation_id',
        'ordre',
    ];

    /**
     * Get the formation that this chapitre belongs to.
     */
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    /**
     * Get the sous-chapitres for this chapitre.
     */
    public function sousChapitres()
    {
        return $this->hasMany(SousChapitre::class);
    }
}

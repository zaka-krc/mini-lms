<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContenuPedagogique extends Model
{
    use HasFactory;

    protected $table = 'contenus_pedagogiques';

    protected $fillable = [
        'titre',
        'texte',
        'lien_ressource',
        'sous_chapitre_id',
    ];

    public function sousChapitre()
    {
        return $this->belongsTo(SousChapitre::class);
    }
}

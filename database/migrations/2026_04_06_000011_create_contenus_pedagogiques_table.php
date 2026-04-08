<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contenus_pedagogiques', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->longText('texte')->nullable();
            $table->string('lien_ressource')->nullable();
            $table->foreignId('sous_chapitre_id')->constrained('sous_chapitres')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contenus_pedagogiques');
    }
};

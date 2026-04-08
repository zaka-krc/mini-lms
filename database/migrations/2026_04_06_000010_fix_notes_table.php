<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            // Ajouter quiz_id (nullable pour ne pas casser les données existantes)
            $table->foreignId('quiz_id')->nullable()->after('user_id')->constrained('quiz')->cascadeOnDelete();
        });

        Schema::table('notes', function (Blueprint $table) {
            // Supprimer matiere (remplacé par quiz_id)
            $table->dropColumn('matiere');
        });

        // Modifier note_sur_20 pour accepter les décimales
        Schema::table('notes', function (Blueprint $table) {
            $table->decimal('note_sur_20', 4, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropForeign(['quiz_id']);
            $table->dropColumn('quiz_id');
            $table->string('matiere')->nullable();
            $table->integer('note_sur_20')->change();
        });
    }
};

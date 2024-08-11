<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatiereProfesseur extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matiere_professeur', function (Blueprint $table) {
            $table->id();
            $table->integer('volume_horaire');
            $table->integer('progression')->default(0);
            $table->enum('statut', ['termine', 'en cours'])->default('en cours');
            $table->foreignId('matiere_id')->constrained();
            $table->foreignId('professeur_id')->constrained();
            $table->foreignId('classe_id')->constrained();
            $table->foreignId('annee_academique_id')->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matiere_professeur');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paiement_professeurs', function (Blueprint $table) {
            $table->id();
            $table->string('objet');
            $table->string('entite');
            $table->string('ville');
            $table->string('mode_paiement');
            $table->text('note');
            $table->date('date_paiement');
            $table->bigInteger('numero_recu');
            $table->bigInteger('montant_paiement');
            $table->foreignId('professeur_id');
            $table->foreignId('personnel_id');
            $table->foreignId('faculte_id');
            $table->foreignId('annee_academique_id')->constrained();
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
        Schema::dropIfExists('paiement_professeurs');
    }
};

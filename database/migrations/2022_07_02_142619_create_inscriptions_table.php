<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('frais_inscription')->nullable();
            $table->string('nom_banque')->nullable();
            $table->string('numero_bordereau')->nullable();
            $table->string('numero_recu')->unique()->nullable();
            $table->date('date_inscription')->nullable();
            $table->date('date_versement')->nullable();
            $table->boolean('prise_chage')->default(0);
            $table->enum('prise_charge_type', ['reduction', 'cas president', 'bourse', 'autre'])->nullable();
            $table->bigInteger('remise')->default(0);
            $table->bigInteger('net_payer')->nullable();
            $table->string('fiche_inscription')->nullable();
            $table->string('fiche_oriantation')->nullable();
            $table->string('extrait_naissance')->nullable();
            $table->string('bac_legalise')->nullable();
            $table->string('cp_note_bac')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('valide')->default(0);
            $table->string('raison')->nullable();
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('inscriptions');
    }
}

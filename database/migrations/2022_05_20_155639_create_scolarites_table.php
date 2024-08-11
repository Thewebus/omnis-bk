<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScolaritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scolarites', function (Blueprint $table) {
            $table->id();
            $table->string('nom_banque');
            $table->string('numero_bordereau');
            $table->bigInteger('code_caisse');
            $table->string('numero_recu')->unique();
            $table->date('date_versement');
            $table->bigInteger('montant_scolarite');
            $table->bigInteger('net_payer')->nullable();
            $table->bigInteger('payee')->default(0);
            $table->bigInteger('versement');
            $table->bigInteger('reste');
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
        Schema::dropIfExists('scolarites');
    }
}

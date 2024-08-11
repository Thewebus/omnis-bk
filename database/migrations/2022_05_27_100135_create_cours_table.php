<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->integer('jour');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->foreignId('classe_id');
            $table->foreignId('matiere_id');
            $table->foreignId('professeur_id');
            $table->foreignId('salle_id');
            $table->foreignId('annee_academique_id');
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
        Schema::dropIfExists('cours');
    }
}

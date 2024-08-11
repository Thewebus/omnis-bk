<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeureAbsencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('heure_absences', function (Blueprint $table) {
            $table->id();
            $table->integer('heure_absence');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('matiere_id')->constrained();
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
        Schema::dropIfExists('heure_absences');
    }
}

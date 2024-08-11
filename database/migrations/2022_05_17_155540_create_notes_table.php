<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->float('note_1')->nullable();
            $table->float('note_2')->nullable();
            $table->float('note_3')->nullable();
            $table->float('note_4')->nullable();
            $table->float('note_5')->nullable();
            $table->float('note_6')->nullable();
            $table->integer('nbr_note')->default(0);
            $table->float('moyenne')->nullable();
            $table->float('partiel_session_1')->nullable();
            $table->float('partiel_session_2')->nullable();
            $table->enum('status', ['admis', 'ajourné'])->nullable();
            $table->enum('systeme_calcul', ['lmd', 'normal'])->nullable();
            $table->foreignId('classe_id')->constrained();
            $table->foreignId('matiere_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('professeur_id')->constrained();
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
        Schema::dropIfExists('notes');
    }
}

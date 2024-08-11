<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcheanciersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('echeanciers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('versement_1');
            $table->string('date_1');
            $table->bigInteger('versement_2');
            $table->string('date_2');
            $table->bigInteger('versement_3');
            $table->string('date_3');
            $table->bigInteger('versement_4');
            $table->string('date_4');
            $table->bigInteger('versement_5');
            $table->string('date_5');
            $table->bigInteger('versement_6');
            $table->string('date_6');
            $table->bigInteger('versement_7');
            $table->string('date_7');
            $table->enum('statut', ['validé', 'en attente','non validé'])->default('en attente');
            $table->text('observation')->nullable();
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
        Schema::dropIfExists('echeanciers');
    }
}

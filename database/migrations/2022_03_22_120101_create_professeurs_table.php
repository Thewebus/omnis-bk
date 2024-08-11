<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfesseursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professeurs', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('numero')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('postale')->nullable();
            $table->string('date_naissance')->nullable();
            $table->string('profession')->nullable();
            $table->enum('statut', ['fonctionnaire', 'salarié'])->nullable();
            $table->string('cnps')->nullable();
            $table->integer('anciennete')->nullable();
            $table->json('modules_enseignes')->nullable();
            $table->string('piece_identite')->nullable();
            $table->string('cv')->nullable();
            $table->string('diplomes')->nullable();
            $table->string('autorisation_enseigner')->nullable();
            $table->string('compte_bancaire')->nullable();
            $table->integer('taux_horaire_bts')->default(0);
            $table->integer('taux_horaire_licence')->default(0);
            $table->integer('taux_horaire_master')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('valide')->default(0);
            $table->string('raison')->nullable();
            $table->boolean('soumettre')->default(0);
            $table->string('type')->default('professeur');
            $table->string('password')->nullable();
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('professeurs');
    }
}

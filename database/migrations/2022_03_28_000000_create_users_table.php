<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('numero_etudiant')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->boolean('delegue')->default(0);
            $table->enum('cursus', ['jour', 'soir'])->nullable();
            $table->enum('sexe', ['masculin', 'feminin'])->nullable();
            $table->enum('statut', ['affecté', 'non affecté', 'réaffecté'])->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('photo')->nullable();
            $table->string('nationalite')->nullable();
            $table->string('type')->default('etudiant');
            $table->string('matricule_etudiant')->nullable();
            $table->string('domicile')->nullable();
            $table->string('etablissement_origine')->nullable();
            $table->string('adresse_geographique')->nullable();
            $table->string('niveau_etude')->nullable();
            $table->string('autre_diplome')->nullable();
            $table->string('serie_bac')->nullable();
            $table->string('premier_entree_ua')->nullable();
            $table->enum('responsable_legal', ['pere', 'mere', 'vivant seul', 'autre'])->nullable();
            $table->string('responsable_legal_precision')->nullable();
            $table->string('responsable_legal_fullname')->nullable();
            $table->string('responsable_legal_profession')->nullable();
            $table->string('responsable_legal_adresse')->nullable();
            $table->string('responsable_legal_domicile')->nullable();
            $table->string('responsable_legal_numero')->nullable();
            $table->string('responsable_scolarite_fullname')->nullable();
            $table->string('responsable_scolarite_profession')->nullable();
            $table->string('responsable_scolarite_adresse')->nullable();
            $table->string('responsable_scolarite_domicile')->nullable();
            $table->string('responsable_scolarite_numero')->nullable();
            $table->foreignId('niveau_faculte_id')->nullable()->constrained();
            $table->foreignId('classe_id')->nullable()->constrained();
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
        Schema::dropIfExists('users');
    }
}

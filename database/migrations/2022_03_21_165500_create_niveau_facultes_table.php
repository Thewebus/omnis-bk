<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNiveauFacultesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('niveau_facultes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->bigInteger('scolarite_affecte');
            $table->bigInteger('scolarite_nonaffecte');
            $table->bigInteger('scolarite_reaffecte');
            $table->foreignId('faculte_id');
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
        Schema::dropIfExists('niveau_facultes');
    }
}

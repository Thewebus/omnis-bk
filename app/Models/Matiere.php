<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matiere extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function professeurs() {
        return $this->belongsToMany(Professeur::class)->withPivot('volume_horaire', 'progression', 'statut', 'classe_id', 'annee_academique_id')->withTimestamps();
    }

    public function classe() {
        return $this->belongsTo(Classe::class);
    }

    public function notes() {
        return $this->hasMany(Note::class);
    }

    public static function isMatiereAvaible($matiere_id, $professeur_id) {
        $matieres = MatiereProfesseur::where('matiere_id', $matiere_id)
            ->where('professeur_id', $professeur_id)->count();

        return !$matieres;
    }

    public function ressourcesCours() {
        return $this->hasMany(ResourcesCours::class);
    }

    public function uniteEnseignement() {
        return $this->belongsTo(UniteEnseignement::class);
    }
}
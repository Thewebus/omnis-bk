<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faculte extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function institut() {
        return $this->belongsTo(Institut::class);
    }

    public function classes() {
        return $this->hasManyThrough(Classe::class, NiveauFaculte::class);
    }

    public function classeNiveau($niveauClasse)
{
    $niveauQuery = $this->niveaux();

    if ($niveauClasse == 'licence' || $niveauClasse == 'master') {
        $niveauQuery->where('nom', 'like', $niveauClasse . '%');
        $classes = $niveauQuery->get()->flatMap(function ($niveau) {
            return $niveau->classes->sortBy('nom');
        });
    } else {
        $classes = $niveauQuery->where('nom', $niveauClasse)
            ->first()
            ->classes ?? collect();
    }

    return $classes;
}

    public function etudiants() {
        return $this->hasMany(User::class);
    }

    public function niveaux() {
        return $this->hasMany(NiveauFaculte::class);
    }

    public function matieres() {
        $matieres = collect();
        foreach ($this->classes as $classe) {
            foreach ($classe->matieres as $matiere) {
                $matieres->push($matiere);
            }
        }
        return $matieres;
    }
}

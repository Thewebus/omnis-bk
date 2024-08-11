<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classe extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function niveauFaculte() {
        return $this->belongsTo(NiveauFaculte::class);
    }

    // public function etudiants() {
    //     return $this->hasMany(User::class);
    // }

    public function etudiants()
    {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();

        return $this->inscriptions()
            ->where('annee_academique_id', $anneeAcademique->id)
            ->with('etudiant')
            ->get()
            ->pluck('etudiant')
            ->sortBy('fullname');
    }

    public function inscriptions() {
        return $this->hasMany(Inscription::class);
    }

    public function professeurs() {
        return $this->belongsToMany(Professeur::class);
    }

    public function presences() {
        return $this->hasMany(Presence::class);
    }

    public function notes() {
        return $this->hasMany(Note::class);
    }

    public function cahierTextes() {
        return $this->hasMany(CahierTexte::class);
    }

    public function cours() {
        return $this->hasMany(Cours::class);
    }

    public function ressourcesCours() {
        return $this->hasMany(ResourcesCours::class);
    }

    public function matieres() {
        return $this->hasMany(Matiere::class);
    }

    public function uniteEnseignements() {
        return $this->belongsToMany(UniteEnseignement::class, 'matieres')->withPivot('id', 'nom', 'numero_ordre', 'semestre', 'deleted_at');
    }

    public function UeMatieres($semestre) {
        $ueMatiere = [];
        $totalCreditUe = [];
        $matieres = $this->matieres
            ->sortBy('numero_ordre')
            ->where('semestre', $semestre)
            ->groupBy('uniteEnseignement.nom');

        // Récupérer les UE avec leur matières
        foreach ($matieres as $ue => $matieresByUe) {
            $ueMatiere[$ue] = array_column($matieresByUe->toArray(), 'nom');
            $totalCreditUe[] = array_sum(array_column($matieresByUe->toArray(), 'credit'));

        }

        // Ajout de "Crédit(s) TotalCredit" aux UE
        $array3 = [];
        $keys = array_keys($ueMatiere);
        foreach ($keys as $index => $key) {
            $credit = $totalCreditUe[$index] ?? 0; // Si l'indice n'existe pas dans $totalCreditUe, on utilise 0
            $array3[$key . " (Crédit(s) " . $credit . ")"] = $ueMatiere[$key];
        }

        return [$array3, array_sum($totalCreditUe)];
    }
    
}

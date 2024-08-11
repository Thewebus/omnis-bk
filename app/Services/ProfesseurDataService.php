<?php

namespace App\Services;

use App\Models\Professeur;
use App\Models\AnneeAcademique;
use App\Models\MatiereProfesseur;
use Illuminate\Database\Eloquent\Builder;

class ProfesseurDataService {
    
    // Data for fiche de vacation page.
    public function vacationData() {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $professeurs = Professeur::whereHas('matiereProfesseur', function(Builder $query) use ($anneeAcademique) {
            $query->where('annee_academique_id', $anneeAcademique->id);
        }, '>', 0)->get();

        $anneeAcademiqueData['debut'] = $anneeAcademique->debut;
        $anneeAcademiqueData['fin'] = $anneeAcademique->fin;

        // $posts = Post::whereHas('comments', function (Builder $query) {
        //     $query->where('content', 'like', 'code%');
        // }, '>=', 10)->get();

        $vacationDatas = [];
        foreach ($professeurs as $professeur) {
            $cours = [];
            $volume_horaire = 0;
            $montantBrute = 0;
            $matierePros = MatiereProfesseur::with('classe', 'matiere')
                ->where('annee_academique_id', $anneeAcademique->id)
                ->where('professeur_id', $professeur->id)->get();
            foreach ($matierePros as $matierePro) {
                array_push($cours, [
                    'classe' => $matierePro->classe->nom ?? 'NONE',
                    'nbr_heure' => $matierePro->volume_horaire,
                    'matiere' => $matierePro->matiere->nom ?? 'NONE',
                ]);

                $volume_horaire += $matierePro->volume_horaire;

                // if($matierePro->matiere->systeme == 'bts') {
                //     $montantBrute += $professeur->taux_horaire_bts;
                // }
                // elseif ($matierePro->matiere->systeme == 'licence') {
                //     $montantBrute += $professeur->taux_horaire_licence;
                // }
                // else {
                //     $montantBrute += $professeur->taux_horaire_master;
                // }
            }

            array_push($vacationDatas, [
                'compte_bancaire' => $professeur->compte_bancaire ?? 'NE10ERI8552',
                'telephone' => $professeur->numero,
                'fullname' => $professeur->fullname,
                'volume_horaire' => $volume_horaire,
                'taux_horaire_bts' => $professeur->taux_horaire_bts,
                'taux_horaire_licence' => $professeur->taux_horaire_licence,
                'taux_horaire_master' => $professeur->taux_horaire_master,
                'montant_brut' => $volume_horaire * $montantBrute,
                'impots' => $professeur->statut == 'salarié' ? 7.50 * $montantBrute / 100 : 0,
                'cnps' => $professeur->statut == 'fonctionnaire' ? 6.30 * $montantBrute / 100 : 0,
                'net_payer' => $professeur->statut == 'salarié' ? $montantBrute - (7.50 * $montantBrute / 100)  : $montantBrute - (6.30 * $montantBrute / 100),
                'cours' => $cours,
            ]);
        }

        return [$vacationDatas, $anneeAcademiqueData];
    }

    public function professeurData() {
        $dataProfesseurs = [];
        $dataProfesseurs['depenseProfesseur'] = 0;
        $dataProfesseurs['TotalVolumeHoraire'] = 0;
        $dataProfesseurs['volumeHoraireBTS'] = 0;
        $dataProfesseurs['prixHoraireBTS'] = 0;
        $dataProfesseurs['volumeHoraireLicence'] = 0;
        $dataProfesseurs['prixHoraireLicence'] = 0;
        $dataProfesseurs['volumeHoraireMaster'] = 0;
        $dataProfesseurs['prixHoraireMaster'] = 0;

        
        
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $professeurs = Professeur::whereHas('matiereProfesseur', function(Builder $query ) use ($anneeAcademique) {
            $query->where('annee_academique_id', $anneeAcademique->id);
        }, '>', 0)->get();

        $dataProfesseurs['nombreProfeseurs'] = $professeurs->count();
        
        foreach ($professeurs as $professeur) {
            $matierePros = MatiereProfesseur::with('matiere')->where('annee_academique_id', $anneeAcademique->id)
                ->where('professeur_id', $professeur->id)->get();

            foreach ($matierePros as $matierePro) {
                $dataProfesseurs['TotalVolumeHoraire'] += $matierePro->volume_horaire;

                // if($matierePro->matiere->systeme == 'bts') {
                //     $dataProfesseurs['volumeHoraireBTS'] += $matierePro->volume_horaire;
                //     $dataProfesseurs['prixHoraireBTS'] += $professeur->taux_horaire_bts;
                // }
                // elseif ($matierePro->matiere->systeme == 'licence') {
                //     $dataProfesseurs['volumeHoraireLicence'] += $matierePro->volume_horaire;
                //     $dataProfesseurs['prixHoraireLicence'] += $professeur->taux_horaire_licence;
                // }
                // else {
                //     $dataProfesseurs['volumeHoraireMaster'] += $matierePro->volume_horaire;
                //     $dataProfesseurs['prixHoraireMaster'] += $professeur->taux_horaire_master;
                // }
            }
        }

        $dataProfesseurs['depenseProfesseur'] = $dataProfesseurs['prixHoraireBTS'] + $dataProfesseurs['prixHoraireLicence'] + $dataProfesseurs['prixHoraireMaster'];
        return $dataProfesseurs;
    }
}
<?php
namespace App\Services;

use App\Models\AnneeAcademique;
use App\Models\Cours;

class ScheduleService {

    public function genererDonneesCalendrier($jours, $classe) {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $donneesCalendrier = [];
        $timeRange = (new TimeService)->generateTimeRange(config('app.calendrier.heure_debut'), config('app.calendrier.heure_fin'));
        $cours = Cours::with('matiere', 'salle', 'professeur')->where('annee_academique_id', $anneeAcademique->id)->where('classe_id', $classe)->get();

        foreach($timeRange as $time) {
            $timeText = $time['debut'] . ' - ' . $time['fin'];
            $donneesCalendrier[$timeText] = [];

            foreach ($jours as $index => $jour) {
                $cour = $cours->where('jour', $index)->where('heure_debut', $time['debut'] . ':00')->first();
                if ($cour) {

                    array_push($donneesCalendrier[$timeText], [
                        'matiere_nom' => $cour->matiere->nom ?? 'NONE',
                        'salle_nom' => $cour->salle->nom,
                        'professeur_nom' => $cour->professeur->fullname,
                        'rowspan' => $cour->difference() / 30 ?? '',
                    ]);
                }
                else if (!$cours->where('jour', $index)->where('heure_debut', '<', $time['debut'])->where('heure_fin', '>=', $time['fin'])->count()) {
                    array_push($donneesCalendrier[$timeText], 1);
                }
                else {
                    array_push($donneesCalendrier[$timeText], 0);
                }
            }
        }

        return $donneesCalendrier;
    }

    public function genererProfesseurDonneesCalendrier($jours, $professeur) {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $donneesCalendrier = [];
        $timeRange = (new TimeService)->generateTimeRange(config('app.calendrier.heure_debut'), config('app.calendrier.heure_fin'));
        $cours = Cours::with('matiere', 'salle')->where('annee_academique_id', $anneeAcademique->id)->where('professeur_id', $professeur)->get();

        foreach($timeRange as $time) {
            $timeText = $time['debut'] . ' - ' . $time['fin'];
            $donneesCalendrier[$timeText] = [];

            foreach ($jours as $index => $jour) {
                $cour = $cours->where('jour', $index)->where('heure_debut', $time['debut'] . ':00')->first();
                if ($cour) {
                    array_push($donneesCalendrier[$timeText], [
                        'matiere_nom' => $cour->matiere->nom ?? 'NONE',
                        'salle_nom' => $cour->salle->nom,
                        'rowspan' => $cour->difference() / 30 ?? '',
                    ]);
                }
                else if (!$cours->where('jour', $index)->where('heure_debut', '<', $time['debut'])->where('heure_fin', '>=', $time['fin'])->count()) {
                    array_push($donneesCalendrier[$timeText], 1);
                }
                else {
                    array_push($donneesCalendrier[$timeText], 0);
                }
            }
        }

        return $donneesCalendrier;
    }
}
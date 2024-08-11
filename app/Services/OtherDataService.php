<?php

namespace App\Services;

use App\Models\Note;
use App\Models\User;
use NumberFormatter;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Inscription;
use App\Models\AnneeAcademique;
use Illuminate\Database\Eloquent\Builder;

class OtherDataService {
    public function scolariteByClasse() {
        // variable initiale
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $scolariteClasseData = [];
        $scolariteClasseData['statut'] = 'scolariteParClasse';
        
        // récupération des classes pour l'année en cours
        $classes = Classe::where('annee_academique_id', $anneeAcademique->id)->orderBy('nom', 'ASC')->get();
        foreach ($classes as $classe) {
            $totalScolariteClasse = 0;
            foreach ($classe->etudiants as $etudiant) {
                // Calcule de la scolarité de la classe courante
                $totalScolariteClasse += $etudiant->inscriptions->last()->net_payer;
            }

            // Remplissage de la variable à retourner
            array_push($scolariteClasseData, [
                'nom' => $classe->nom,
                'niveau' => $classe->niveauFiliere->nom,
                'filiere' => $classe->niveauFiliere->filiere->nom,
                'scolarite' => $totalScolariteClasse,
            ]);
        }

        return $scolariteClasseData;
    }

    public function scolaritePayerByClasse() {
        // variable initiale
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $scolariteClasseData = [];
        $scolariteClasseData['statut'] = 'scolaritePayeeParClasse';


        // récupération des classes pour l'année en cours
        $classes = Classe::where('annee_academique_id', $anneeAcademique->id)->orderBy('nom', 'ASC')->get();

        foreach ($classes as $classe) {
            $totalScolaritePayerClasse = 0;
            foreach ($classe->etudiants as $etudiant) {
                // Calcul de scolarité payé
                $totalScolaritePayerClasse += $etudiant->scolarites->where('annee_academique_id', $anneeAcademique->id)->sum('payee');
            }

            // Remplissage de la variable à retourner
            array_push($scolariteClasseData, [
                'nom' => $classe->nom,
                'niveau' => $classe->niveauFiliere->nom,
                'filiere' => $classe->niveauFiliere->filiere->nom,
                'scolarite' => $totalScolaritePayerClasse,
            ]);
        }

        return $scolariteClasseData;
    }

    public function scolariteRestanteByClasse() {
        // variable initiale
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $scolariteClasseData = [];
        $scolariteClasseData['statut'] = 'scolariteRestanteParClasse';

        // récupération des classes pour l'année en cours
        $classes = Classe::where('annee_academique_id', $anneeAcademique->id)->orderBy('nom', 'ASC')->get();

        foreach ($classes as $classe) {
            $totalScolariteClasse = 0;
            $totalScolaritePayerClasse = 0;
            foreach ($classe->etudiants as $etudiant) {
                // Calcule de la scolarité de la classe courante
                $totalScolariteClasse += $etudiant->inscriptions->last()->net_payer;

                // Calcul de scolarité payé de la classe courante
                $totalScolaritePayerClasse += $etudiant->scolarites->where('annee_academique_id', $anneeAcademique->id)->sum('payee');
            }

            $scolariteRestante = $totalScolariteClasse - $totalScolaritePayerClasse;

            // Remplissage de la variable à retourner
            array_push($scolariteClasseData, [
                'nom' => $classe->nom,
                'niveau' => $classe->niveauFiliere->nom,
                'filiere' => $classe->niveauFiliere->filiere->nom,
                'scolarite' => $scolariteRestante,
            ]);
        }

        return $scolariteClasseData;
    }

    public function notesMatiere($matiereId) {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $matiere = Matiere::findOrFail($matiereId);
        $dataNotes = [];

        // Récupération des étudiants de la classe à laquelle appartient la matière 
        // $etudiants = User::where('classe_id', $matiere->classe->id)->orderBy('fullname', 'ASC')->get();
        $etudiants = User::whereHas('inscriptions', function(Builder $query) use ($anneeAcademique, $matiere) {
            $query->where('classe_id', $matiere->classe->id)->where('annee_academique_id', $anneeAcademique->id);
        })->orderBy('fullname', 'asc')->get();

        foreach ($etudiants as $etudiant) {
            $notes = Note::where('user_id', $etudiant->id)->where('annee_academique_id', $anneeAcademique->id)
                ->where('classe_id', $matiere->classe->id)->where('matiere_id', $matiere->id)->first();
            array_push($dataNotes, [
                'nom_etudiant' => $etudiant,
                'note_1' => $notes->note_1 ?? 'NONE',
                'note_2' => $notes->note_2 ?? 'NONE',
                'note_3' => $notes->note_3 ?? 'NONE',
                'note_4' => $notes->note_4 ?? 'NONE',
                'note_5' => $notes->note_5 ?? 'NONE',
                'note_6' => $notes->note_6 ?? 'NONE',
                'moyenne' => $notes->moyenne ?? 'NONE',
                'partiel_session_1' => $notes->partiel_session_1 ?? 'NONE',
                'partiel_session_2' => $notes ? ($notes->moyenne < 10 ? $notes->partiel_session_2 : 'NONE') : 'NONE',
                'decision_finale' => $notes->status ?? 'NONE'
            ]);
        }

        $noteSelectionnees = $notes->notes_selectionnees ?? [];
        $systemeCalcul = $notes->systeme_calcul ?? null;

        return [$matiere->classe->nom, $matiere , $dataNotes, $noteSelectionnees, $systemeCalcul ?? []];
    }

    public function noteEtudiant($inscriptionId, $semestre) {
        $inscription = Inscription::findOrFail($inscriptionId);
        $etudiant = $inscription->etudiant;

        $anneeAcademique = $inscription->anneeAcademique;
        // $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $dataNotes = [];

        foreach ($inscription->classe->matieres->where('semestre', $semestre) as $matiere) {
            $notes = Note::where('user_id', $etudiant->id)->where('annee_academique_id', $anneeAcademique->id)
            ->where('classe_id', $matiere->classe->id)->where('matiere_id', $matiere->id)->first();
            
            array_push($dataNotes, [
                'nom_matiere' => $matiere->nom,
                'note_1' => $notes->note_1 ?? 'NONE',
                'note_2' => $notes->note_2 ?? 'NONE',
                'note_3' => $notes->note_3 ?? 'NONE',
                'note_4' => $notes->note_4 ?? 'NONE',
                'note_5' => $notes->note_5 ?? 'NONE',
                'note_6' => $notes->note_6 ?? 'NONE',
                'moyenne' => $notes->moyenne ?? 'NONE',
                'partiel_session_1' => $notes->partiel_session_1 ?? 'NONE',
                'partiel_session_2' => (!is_null($notes) ? $notes->moyenne < 10 : 'NONE') ? (!is_null($notes) ? $notes->partiel_session_2 : 'NONE') : 'NONE',
                'decision_finale' => $notes->status ?? 'NONE'
            ]);

        }

        return $dataNotes;
    }

    public function calculMoyenne($systemeCalcul, $notes, $noteSelectionnee) {
        $sommeNote = 0;
        $moyenne = 0;
        
        if($systemeCalcul == 'normal') {
            foreach($notes as $note_x => $noteCourante) {
                in_array($note_x, $noteSelectionnee) ? $sommeNote += $noteCourante : '';
            }

            $moyenne = $sommeNote / count($noteSelectionnee);
            $status = $moyenne >= 10 ? 'admis' : 'ajourné';
        }
        else {
            foreach($notes as $note_x => $noteCourante) {
                if ($note_x !== 'partiel_session_1') {
                    in_array($note_x, $noteSelectionnee) ? $sommeNote += $noteCourante : '';
                }
            }
            
            in_array('partiel_session_1', $noteSelectionnee) ? $diviseur = (count($noteSelectionnee) - 1) : $diviseur = count($noteSelectionnee);
            $moyenne = (0.4 * ($sommeNote / $diviseur)) + (($notes['partiel_session_1']) * 0.6); 
            $status = $moyenne >= 10 ? 'admis' : 'ajourné';
        }

        return [$moyenne, $status];
    }

    public function montantScolarite(string $status, Classe $classe) {
        if ($status == 'affecté') {
            $scolarite = $classe->niveauFaculte->scolarite_affecte;
        } else if ($status == 'non affecté') {
            $scolarite = $classe->niveauFaculte->scolarite_nonaffecte;
        }
        else {
            $scolarite = $classe->niveauFaculte->scolarite_reaffecte;    
        }

        return $scolarite;
    }

    public static function nombreEnLettres($nombre) {
        // On vérifie que le nombre est valide
        if (!is_numeric($nombre) || $nombre < 0 || $nombre > 9999999) {
            return false;
        }
        // On crée un objet NumberFormatter avec la locale française
        $nf = new NumberFormatter("fr", NumberFormatter::SPELLOUT);
        // On formate le nombre en lettres
        $lettres = $nf->format($nombre);
        // On remplace les espaces par des traits d'union pour les nombres composés
        $lettres = preg_replace("/(\d+)-(\d+)/", "$1$2", $lettres);
        // On ajoute la conjonction "et" pour les nombres se terminant par 1
        $lettres = preg_replace("/(\d+) et un$/", "$1-et-un", $lettres);
        // On retourne le résultat
        return strtoupper($lettres);
    }
    

    public function deliberationClasse(Classe $classe, int $semestre, int $session) {
        $nbrTotal = $classe->etudiants()->count();
        $nbrAdmis = 0;
        $nbrAjournes = 0;
        foreach($classe->etudiants() as $etudiant) {
            
        }
    }

    function compareMoyenneFinaleDesc($a, $b)
    {
        return $b["moyenne_finale"] <=> $a["moyenne_finale"];
    }

    public function classement(array $bulletinDatas) {
        $moyenneClasse = [];
        $moyennesMatiere = [];

        $array = [
            [
                "matiere" => "Technique d’expression écrite et orale",
                "coefficient" => 1,
                "credit" => 1,
                "moyenne" => 9.7,
                "moyCred" => 0.0,
                "resultat" => "Non validée",
                "mention" => "",
                "nom_professeur" => "DR. COULIBALY AMIDOU",
            ],
            [
                "matiere" => "Anglais Commercial",
                "coefficient" => 3,
                "credit" => 3,
                "moyenne" => 14.8,
                "moyCred" => 0.0,
                "resultat" => "Non validée",
                "mention" => "",
                "nom_professeur" => "DR. DADI MAHI ESAIE",
            ],
            [
                "matiere" => "Economie Générale & Economie et Organisation d’Entreprise",
                "coefficient" => 2,
                "credit" => 2,
                "moyenne" => 7.5,
                "moyCred" => 0.0,
                "resultat" => "Non validée",
                "mention" => "",
                "nom_professeur" => "DR. DADI MAHI ESAIE",
            ],
            [
                "matiere" => "Technique d’expression écrite et orale",
                "coefficient" => 1,
                "credit" => 1,
                "moyenne" => 15,
                "moyCred" => 0.0,
                "resultat" => "Non validée",
                "mention" => "",
                "nom_professeur" => "DR. COULIBALY AMIDOU",
            ],
            [
                "matiere" => "Anglais Commercial",
                "coefficient" => 3,
                "credit" => 3,
                "moyenne" => 7.7,
                "moyCred" => 0.0,
                "resultat" => "Non validée",
                "mention" => "",
                "nom_professeur" => "DR. DADI MAHI ESAIE",
            ],
            [
                "matiere" => "Economie Générale & Economie et Organisation d’Entreprise",
                "coefficient" => 2,
                "credit" => 2,
                "moyenne" => 12.6,
                "moyCred" => 0.0,
                "resultat" => "Non validée",
                "mention" => "",
                "nom_professeur" => "DR. DADI MAHI ESAIE",
            ],
        ];


        $result = [
            "Technique d’expression écrite et orale" => [9.7, 15],
            "Anglais Commercial" => [14.8, 7.7],
            "Economie Générale & Economie et Organisation d’Entreprise" => [7.5, 12.6],
        ];

        $temp = [];

        foreach ($array as $item) {
            $matiere = $item['matiere'];
            $moyenne = $item['moyenne'];

            if (!isset($temp[$matiere])) {
                $temp[$matiere] = [];
            }

            $temp[$matiere][] = $moyenne;
        }

        // $result = array_reduce($array, function ($result, $item) {
        //     $matiere = $item['matiere'];
        //     $moyenne = $item['moyenne'];
        
        //     $result[$matiere][] = $moyenne;
        
        //     return $result;
        // }, []);

        // dd($temp, $result);
        // dd($bulletinDatas[0]['unite_enseignements'][0]);
        foreach($bulletinDatas as $bulletinData) {
            foreach($bulletinData['unite_enseignements'] as $unite_enseignements) {
                $temp = [];
                foreach($unite_enseignements as $key =>  $matiere)
                {
                    if(is_int($key)) {
                        $nomMatiere = $matiere['matiere'];
                        $moyenne = $matiere['moyenne'];

                        if (!isset($temp[$nomMatiere])) {
                            $temp[$nomMatiere] = [];
                        }

                        $temp[$nomMatiere][] = $moyenne;
                        
                    }
                }
                // dump($temp);
                // array_push($moyennesMatiere, $temp);
            }
        }        
        // dd($moyennesMatiere);
    }
    
}
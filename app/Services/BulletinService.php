<?php
namespace App\Services;

use App\Models\Note;
use App\Models\User;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Inscription;
use App\Models\AnneeAcademique;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class BulletinService {
    public function nombreFormatDeuxDecimal(string $nombre) {
        $nombreFormate = number_format($nombre, 2, ',', '');
        $nombreFormate = str_pad($nombreFormate, 5, '0', STR_PAD_LEFT);
        return $nombreFormate;
    }

    public function mention($moyenne)
    {
        if ($moyenne >= 16) {
            $mention = 'Très bien';
        } elseif ($moyenne >= 14) {
            $mention = 'Bien';
        } elseif ($moyenne >= 12) {
            $mention = 'Assez bien';
        } elseif ($moyenne >= 10) {
            $mention = 'Passable';
        } elseif ($moyenne >= 8) {
            $mention = 'Insuffisant';
        } else {
            $mention = '';
        }
        
        return $mention;
    }

    public function listeEtudiantBulletion(Classe $classe, int $session = null): SupportCollection {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $listeEtudiants = $classe->etudiants();

        if($session == 2) {
            $listeEtudiants = collect();
 
            foreach($classe->etudiants() as $etudiant) {
                if(!is_null($etudiant)) {
                    foreach($classe->matieres as $matiere) {
                        $note = Note::where('annee_academique_id', $anneeAcademique->id)
                            ->where('matiere_id', $matiere->id)
                            ->where('classe_id', $classe->id)
                            ->where('user_id', $etudiant->id)
                            ->first();
    
                        if(!is_null($note)) {
                            // if($note->partiel_session_1 < 10 || $note->partiel_session_1 == "NONE" || $note->moyenne < 10);
                            if($note->moyenne < 10);
                                {$listeEtudiants->push($etudiant); break;}
                        }
                        else {$listeEtudiants->push($etudiant); break;}
    
                    }
                }

            }
        }

        return $listeEtudiants;
    }

    // Code optimiser de la fonction
    // private function listeEtudiantBulletion(Classe $classe, int $session): SupportCollection {
    //     $anneeAcademique = getSelectedAnneeAcademique() ?? getLastAnneeAcademique();

    //     $listeEtudiants = $classe->etudiants()->where(function ($query) use ($session, $anneeAcademique, $classe) {
    //         $query->whereHas('notes', function ($subquery) use ($session, $anneeAcademique, $classe) {
    //             $subquery->where('annee_academique_id', $anneeAcademique->id);
    //             $subquery->where('classe_id', $classe->id);

    //             if ($session == 2) {
    //                 $subquery->where(function ($subsubquery) {
    //                     $subsubquery->where(function ($noteQuery) {
    //                         $noteQuery->where('partiel_session_1', '<', 10)
    //                             ->orWhere('partiel_session_1', 'NONE');
    //                     });

    //                     $subsubquery->orWhere('moyenne', '<', 10);
    //                 });
    //             }
    //         });
    //     })->get();

    //     return $listeEtudiants;
    // }

    private function moyenneSemestre1(Classe $classe, $anneeAcademiqueId, $etudiantId, $session) {
        $sommeMoyenne = 0;
        $nbrMatiere = 0;
        $creditsValidee = 0;
        $totalCredits = 0;

        foreach($classe->matieres->where('semestre', 1) as $matiere) {
            $note = Note::where('annee_academique_id', $anneeAcademiqueId)
                ->where('matiere_id', $matiere->id)
                ->where('classe_id', $classe->id)
                ->where('user_id', $etudiantId)
                ->first();
            
            if($session == 1) {
                // $sommeMoyenne += !is_null($note) ? ($note->partiel_session_1 < 10 || $note->partiel_session_1 == "NONE" || $note->moyenne < 10 ? $note->partiel_session_2 : $note->moyenne) : 0;
                $sommeMoyenne += !is_null($note) ? $note->moyenne : 0;
                // $creditsValidee += !is_null($note) ? (($note->moyenne < 10 && (is_null($note->partiel_session_2) || $note->partiel_session_2 < 10)) ? 0 : $matiere->credit) : 0;
                $creditsValidee += !is_null($note) ? ($note->moyenne >= 10 ? $matiere->credit : 0) : 0;
                $nbrMatiere++;
                $totalCredits += $matiere->credit;
            }
            else {
                if ($note && $note->moyenne < 10) {

                    $sommeMoyenne += !is_null($note) ? $note->partiel_session_2 : 0;
                    $creditsValidee += !is_null($note) ? ($note->partiel_session_2 >= 10 ? $matiere->credit : 0) : 0;
                    $nbrMatiere++;
                    $totalCredits += $matiere->credit;
                    // $moyenne = $note->partiel_session_2 ?? 0;
                } else {
                    $sommeMoyenne += !is_null($note) ? $note->moyenne : 0;
                    $creditsValidee += !is_null($note) ? ($note->moyenne >= 10 ? $matiere->credit : 0) : 0;
                    $nbrMatiere++;
                    $totalCredits += $matiere->credit;
                }
            }

        }

        $moyenneFinaleSemestre1 = $sommeMoyenne / $nbrMatiere;
        return [$moyenneFinaleSemestre1, $creditsValidee, $totalCredits];
    }

    public function classementMoyenne(array $array, float $moyenne)
    {
        // Trier le tableau par ordre décroissant de "moyenne_finale"
        $arrayTrie = collect($array)->sortByDesc('moyenne_finale')->values()->toArray();

        // Trouver l'index de l'élément avec la valeur de "moyenne_finale" donnée
        $index = array_search($moyenne, array_column($arrayTrie, 'moyenne_finale'));

        if ($index !== false) {
            // Retourner le rang (indexé à partir de 1)
            return $index + 1;
        }
        return "Something gone wrong";
    }

    public function classementMatiere(array $array, float $moyenne) {
        // Trier le tableau par ordre décroissant
        $arrayTrie = collect($array)->sortDesc()->values()->toArray();

        // Trouver l'index de l'élément donnée
        $index = array_search($moyenne, $arrayTrie);

        if ($index !== false) {
            // Retourner le rang (indexé à partir de 1)
            return $index + 1;
        }
        return "Something gone wrong";
    }

    public function moyenneUe(int $classeId, int $ueId, int $session = 1) {
        $classe = Classe::findOrFail($classeId);
        $matieres = Matiere::where(['classe_id' => $classe->id])->where(['unite_enseignement_id' => $ueId])->get();
        $listeEtudiants = $this->listeEtudiantBulletion($classe, $session);
        $anneeAcademique = getSelectedAnneeAcademique() ?? getLastAnneeAcademique();
        $moyEu = [];

        foreach($listeEtudiants as $etudiant) {
            $moyenneCoef = 0;
            $totalCred = $matieres->count() > 0 ? 0 : 1;
            foreach($matieres as $matiere) {
                $notes = Note::where(['annee_academique_id' => $anneeAcademique->id])
                    ->where(['classe_id' => $classe->id])
                    ->where(['matiere_id' => $matiere->id])
                    ->where(['user_id' => $etudiant->id])
                    ->first();

                if ($session == 1) {
                    $moyenne = $notes ? ($notes->moyenne ?? 0) : 0;
                } else {
                    if ($notes && $notes->moyenne < 10) {
                        $moyenne = $notes->partiel_session_2 ?? 0;
                    } else {
                        $moyenne = $notes ? ($notes->moyenne ?? 0) : 0;
                    }
                }

                $notes ? ($moyenneCoef += $moyenne * $matiere->credit) : $moyenneCoef += 0;
                $totalCred += $matiere->credit;
            }
            $moyenneUe = number_format(($moyenneCoef / $totalCred), 2);
            array_push($moyEu, [
                $session == 1 ? 'moyenne' : 'partiel_session_2' => $moyenneUe
            ]);
        }

        return collect($moyEu);
    }

    public function bulletinClasse($classe, $semestre, $session) {
        $classe = Classe::findOrFail($classe);
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $uniteEnseignements = array_unique(array_column($classe->uniteEnseignements->toArray(), 'nom'));
        $bulletinDatas = [];
        $listeEtudiantBulletion = $this->listeEtudiantBulletion($classe, $session);
        $moyennesMatieres = [];
        $moyennesAnnuelles = [];
        $moyennesFinalesSemestre1 = [];

        foreach ($listeEtudiantBulletion as $etudiant) {
            $totalCreditValidee = 0;
            $totalCredits = 0;
            $totalCoefficients = 0;
            $moyCreds = 0;
            $sommeMoyenee = 0;
            $nbrMatiere = 0;
            $moyenneFinaleSemestre1 = 0;
            $creditValideesSemestre1 = 0;
            $TotalCreditsSemestre1 = 0;
            $moyenneAnnuelle = 0;
            $ues = [];

            if(!is_null($etudiant)) {
                count($uniteEnseignements) == 0 ? $note = null : '';
                foreach ($uniteEnseignements as $uniteEnseignement) {
                    $uniteEnseignementCourante = [];
                    $uniteEnseignementCourante['nom'] = $uniteEnseignement;
    
                    foreach($classe->matieres->where('semestre', $semestre)->sortBy('numero_ordre') as $matiere) {
                        if($uniteEnseignement == $matiere->uniteEnseignement->nom) {
                            $note = Note::with('professeur')->where('annee_academique_id', $anneeAcademique->id)
                                ->where('matiere_id', $matiere->id)
                                ->where('classe_id', $classe->id)
                                ->where('user_id', $etudiant->id)
                                ->first();

                            if ($session == 1) {
                                $moyenne = $note ? ($note->moyenne ?? 0) : 0;
                            } else {
                                if ($note && $note->moyenne < 10) {
                                    $moyenne = $note->partiel_session_2 ?? 0;
                                } else {
                                    $moyenne = $note ? ($note->moyenne ?? 0) : 0;
                                }
                            }
                            $moyennesMatieres[$matiere->nom][] = $moyenne;
                            array_push($uniteEnseignementCourante ,[
                                'matiere' => $matiere->nom,
                                'coefficient' => $matiere->coefficient,
                                'credit' => $matiere->credit,
                                'credit_moyenne' => $matiere->credit * $moyenne,
                                'moyenne' => $this->nombreFormatDeuxDecimal($moyenne),
                                'moyCred' => !is_null($note) ? (!is_null($moyenne) ? ($moyenne * $matiere->credit) : 0) : 0,
                                'resultat' => !is_null($note) ? (!is_null($moyenne) ? ($moyenne >= 10 ? 'Validée' : 'Non validée') : 'Non validée') : 'Non validée',
                                'mention' => !is_null($note) ? $this->mention($moyenne) : $this->mention(0),
                                'nom_professeur' => !is_null($note) ? $note->professeur->fullname : 'Nom professeur',
                            ]);
    
                            !is_null($note) ? (!is_null($moyenne) ? ($moyenne >= 10 ? $totalCreditValidee += $matiere->credit : $totalCreditValidee += 0) : '') : '';
                            $totalCredits += $matiere->credit;
                            $moyCreds += !is_null($note) ? (!is_null($moyenne) ? ($moyenne * $matiere->credit) : 0) : 0;
                            $totalCoefficients += $matiere->coefficient;
                            $sommeMoyenee += !is_null($note) ? $moyenne : 0;
                            $nbrMatiere++;
                        }
                    }
                    count($uniteEnseignementCourante) > 1 ? array_push($ues, $uniteEnseignementCourante) : '';
                }
    
                $moyennFinale = $nbrMatiere !== 0 ? $sommeMoyenee / $nbrMatiere : 0;
                if($semestre == 2) {
                    $dataSemestre1 = $this->moyenneSemestre1($classe, $anneeAcademique->id, $etudiant->id, $session);
                    $moyenneFinaleSemestre1 = $dataSemestre1[0];
                    $creditValideesSemestre1 = $dataSemestre1[1];
                    $TotalCreditsSemestre1 = $dataSemestre1[2];
                    $moyenneAnnuelle = ($moyennFinale + $moyenneFinaleSemestre1) / 2;
                    $moyennesAnnuelles[] = $moyenneAnnuelle;
                    $moyennesFinalesSemestre1[] = $moyenneFinaleSemestre1;
                }
    
                array_push($bulletinDatas, [
                    'anneeAcademique' => $anneeAcademique->debut . ' - ' . $anneeAcademique->fin,
                    'semestre' => $semestre,
                    'session' => $session,
                    'faculte' => $classe->niveauFaculte->faculte->nom,
                    'fullname' => $etudiant->fullname,
                    'statut' => $etudiant->statut,
                    'sexe' => $etudiant->sexe,
                    'dateNais' => $etudiant->date_naissance->format('d/m/Y'),
                    'lieuNais' => $etudiant->lieu_naissance,
                    'matricule_etudiant' => $etudiant->matricule_etudiant,
                    'classe' => $classe->nom,
                    'unite_enseignements' => $ues,
                    'moyenne_semestre' => $totalCredits,
                    'total_coefficient' => $totalCoefficients,
                    'resultat_final' => $totalCreditValidee == $totalCredits ? 'Semestre Validée ' : 'Semestre non Validé',
                    'mention_finale' => $this->mention($moyennFinale),
                    'moyenne_finale' => $moyennFinale,
                    'moyenne_semestre_1' => $semestre == 2 ? $moyenneFinaleSemestre1 : '',
                    'credits_validee_semestre_1' => $semestre == 2 ? $creditValideesSemestre1 : '',
                    'total_credits_semestre_1' => $semestre == 2 ? $TotalCreditsSemestre1 : '',
                    'resultat_semestre_1' => $semestre == 2 ? ($creditValideesSemestre1 == $TotalCreditsSemestre1 ? 'Semestre validé' : 'Semestre Non validé') : '',
                    'moyenne_annelle' => $semestre == 2 ? $moyenneAnnuelle : 0,
                    'total_credit_validee' => $totalCreditValidee,
                    'total_credit' => $totalCredits,
                    'etudiant_id' => $etudiant->id,
                    'identifiant_bulletin' => $etudiant->identifiant_bulletin . '/R/SG/INFO',
                    'moyennes_matieres' => $moyennesMatieres,
                    'moyennes_annelles' => $moyennesAnnuelles,
                    'moyennes_finales_semestre1' => $moyennesFinalesSemestre1,
                ]);
            }
        }

        return $bulletinDatas;
    }

    public function bulletinClasseOld($classe, $semestre, $session) {
        $classe = Classe::findOrFail($classe);
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $uniteEnseignements = array_unique(array_column($classe->uniteEnseignements->toArray(), 'nom'));
        $bulletinDatas = [];
        $listeEtudiantBulletion = $this->listeEtudiantBulletion($classe, $session);
        $moyennesMatieres = [];
        $moyennesAnnuelles = [];
        $moyennesFinalesSemestre1 = [];

        foreach ($listeEtudiantBulletion as $etudiant) {
            $totalCreditValidee = 0;
            $totalCredits = 0;
            $totalCoefficients = 0;
            $moyCreds = 0;
            $sommeMoyenee = 0;
            $nbrMatiere = 0;
            $moyenneFinaleSemestre1 = 0;
            $creditValideesSemestre1 = 0;
            $TotalCreditsSemestre1 = 0;
            $moyenneAnnuelle = 0;
            $ues = [];

            if(!is_null($etudiant)) {
                count($uniteEnseignements) == 0 ? $note = null : '';
                foreach ($uniteEnseignements as $uniteEnseignement) {
                    $uniteEnseignementCourante = [];
                    $uniteEnseignementCourante['nom'] = $uniteEnseignement;
    
                    foreach($classe->matieres->where('semestre', $semestre)->sortBy('numero_ordre') as $matiere) {
                        if($uniteEnseignement == $matiere->uniteEnseignement->nom) {
                            $note = Note::with('professeur')->where('annee_academique_id', $anneeAcademique->id)
                                ->where('matiere_id', $matiere->id)
                                ->where('classe_id', $classe->id)
                                ->where('user_id', $etudiant->id)
                                ->first();
    
                            if ($session == 1) {
                                $moyenne = $note ? ($note->moyenne ?? 0) : 0;
                            } else {
                                if ($note && $note->moyenne < 10) {
                                    $moyenne = $note->partiel_session_2 ?? 0;
                                } else {
                                    $moyenne = $note ? ($note->moyenne ?? 0) : 0;
                                }
                            }
    
                            $moyennesMatieres[$matiere->nom][] = $moyenne;
                            array_push($uniteEnseignementCourante ,[
                                'matiere' => $matiere->nom,
                                'coefficient' => $matiere->coefficient,
                                'credit' => $matiere->credit,
                                'credit_moyenne' => $matiere->credit * $moyenne,
                                'moyenne' => $this->nombreFormatDeuxDecimal($moyenne),
                                'moyCred' => !is_null($note) ? (!is_null($moyenne) ? ($moyenne * $matiere->credit) : 0) : 0,
                                'resultat' => !is_null($note) ? (!is_null($moyenne) ? ($moyenne >= 10 ? 'Validée' : 'Non validée') : 'Non validée') : 'Non validée',
                                'mention' => !is_null($note) ? $this->mention($moyenne) : $this->mention(0),
                                'nom_professeur' => !is_null($note) ? $note->professeur->fullname : 'Nom professeur',
                            ]);
    
                            !is_null($note) ? (!is_null($moyenne) ? ($moyenne >= 10 ? $totalCreditValidee += $matiere->credit : $totalCreditValidee += 0) : '') : '';
                            $totalCredits += $matiere->credit;
                            $moyCreds += !is_null($note) ? (!is_null($moyenne) ? ($moyenne * $matiere->credit) : 0) : 0;
                            $totalCoefficients += $matiere->coefficient;
                            $sommeMoyenee += !is_null($note) ? $moyenne : 0;
                            $nbrMatiere++;
                        }
                    }
                    count($uniteEnseignementCourante) > 1 ? array_push($ues, $uniteEnseignementCourante) : '';
                }
    
                $moyennFinale = $nbrMatiere !== 0 ? $sommeMoyenee / $nbrMatiere : 0;
                if($semestre == 2) {
                    $dataSemestre1 = $this->moyenneSemestre1($classe, $anneeAcademique->id, $etudiant->id, $session);
                    $moyenneFinaleSemestre1 = $dataSemestre1[0];
                    $creditValideesSemestre1 = $dataSemestre1[1];
                    $TotalCreditsSemestre1 = $dataSemestre1[2];
                    $moyenneAnnuelle = ($moyennFinale + $moyenneFinaleSemestre1) / 2;
                    $moyennesAnnuelles[] = $moyenneAnnuelle;
                    $moyennesFinalesSemestre1[] = $moyenneFinaleSemestre1;
                }
    
                array_push($bulletinDatas, [
                    'anneeAcademique' => $anneeAcademique->debut . ' - ' . $anneeAcademique->fin,
                    'semestre' => $semestre,
                    'session' => $session,
                    'faculte' => $classe->niveauFaculte->faculte->nom,
                    'fullname' => $etudiant->fullname,
                    'dateNais' => $etudiant->date_naissance->format('d/m/Y'),
                    'lieuNais' => $etudiant->lieu_naissance,
                    'matricule_etudiant' => $etudiant->matricule_etudiant,
                    'classe' => $classe->nom,
                    'unite_enseignements' => $ues,
                    'moyenne_semestre' => $totalCredits,
                    'total_coefficient' => $totalCoefficients,
                    'resultat_final' => $totalCreditValidee == $totalCredits ? 'Semestre Validée ' : 'Semestre non Validé',
                    'mention_finale' => $this->mention($moyennFinale),
                    'moyenne_finale' => $moyennFinale,
                    'moyenne_semestre_1' => $semestre == 2 ? $moyenneFinaleSemestre1 : '',
                    'credits_validee_semestre_1' => $semestre == 2 ? $creditValideesSemestre1 : '',
                    'total_credits_semestre_1' => $semestre == 2 ? $TotalCreditsSemestre1 : '',
                    'resultat_semestre_1' => $semestre == 2 ? ($creditValideesSemestre1 == $TotalCreditsSemestre1 ? 'Semestre validé' : 'Semestre Non validé') : '',
                    'moyenne_annelle' => $semestre == 2 ? $moyenneAnnuelle : '',
                    'total_credit_validee' => $totalCreditValidee,
                    'total_credit' => $totalCredits,
                    'etudiant_id' => $etudiant->id,
                    'identifiant_bulletin' => $etudiant->identifiant_bulletin . '/R/SG/INFO',
                    'moyennes_matieres' => $moyennesMatieres,
                    'moyennes_annelles' => $moyennesAnnuelles,
                    'moyennes_finales_semestre1' => $moyennesFinalesSemestre1,
                ]);
            }
        }

        return $bulletinDatas;
    }

    public function bulletinEtudiant($etudiantId, $semestre, $session) {
        $etudiant = User::findOrFail($etudiantId);
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $classe = $etudiant->classe($anneeAcademique->id);
        $uniteEnseignements = array_unique(array_column($classe->uniteEnseignements->toArray(), 'nom'));
        $bulletinDatas = [];
        
        $totalCreditValidee = 0;
        $totalCredits = 0;
        $totalCoefficients = 0;
        $moyCreds = 0;
        $sommeMoyenne = 0;
        $nbrMatiere = 0;
        $ues = [];

        foreach ($uniteEnseignements as $uniteEnseignement) {
            $uniteEnseignementCourante = [];
            $uniteEnseignementCourante['nom'] = $uniteEnseignement;

            foreach($classe->matieres->where('semestre', $semestre)->sortBy('numero_ordre') as $matiere) {
                if($uniteEnseignement == $matiere->uniteEnseignement->nom) {
                    $note = Note::with('professeur')->where('annee_academique_id', $anneeAcademique->id)
                        ->where('matiere_id', $matiere->id)
                        ->where('classe_id', $classe->id)
                        ->where('user_id', $etudiant->id)
                        ->first();
                    
                        // if($session == 1) {
                        //     if(!is_null($note)) {
                        //         $moyenne = $note->moyenne ?? 0;
                        //     }
                        //     else {
                        //         $moyenne = 0;
                        //     }
                        // } else {
                        //     if(!is_null($note)) {
                        //         if(($note->partiel_session_1 < 10 || $note->partiel_session_1 == "NONE") && $note->moyenne < 10)
                        //         {
                        //             $moyenne = $note->partiel_session_2 ?? 0;
                        //         }
                        //         else {
                        //             $moyenne = $note->moyenne ?? 0;
                        //         }
                        //     }
                        //     else {
                        //         $moyenne = 0;
                        //     }
                        // }
                    if ($session == 1) {
                        $moyenne = $note ? ($note->moyenne ?? 0) : 0;
                    } else {
                        // if ($note && ($note->partiel_session_1 < 10 || $note->partiel_session_1 == "NONE" || $note->moyenne < 10)) {
                        if ($note && $note->moyenne < 10) {
                            $moyenne = $note->partiel_session_2 ?? 0;
                        } else {
                            $moyenne = $note ? ($note->moyenne ?? 0) : 0;
                        }
                    }

                    array_push($uniteEnseignementCourante ,[
                        'matiere' => $matiere->nom,
                        'coefficient' => $matiere->coefficient,
                        'credit' => $matiere->credit,
                        'credit_moyenne' => $matiere->credit * $moyenne,
                        'moyenne' => $this->nombreFormatDeuxDecimal($moyenne),
                        'moyCred' => !is_null($note) ? (!is_null($moyenne) ? ($moyenne * $matiere->credit) : 0) : 0,
                        'resultat' => !is_null($note) ? (!is_null($moyenne) ? ($moyenne >= 10 ? 'Validée' : 'Non validée') : 'Non validée') : 'Non validée',
                        'mention' => !is_null($note) ? $this->mention($moyenne) : $this->mention(0),
                        'nom_professeur' => !is_null($note) ? $note->professeur->fullname : 'Nom professeur',
                    ]);
                    !is_null($note) ? (!is_null($moyenne) ? ($moyenne >= 10 ? $totalCreditValidee += $matiere->credit : $totalCreditValidee += 0) : '') : '';
                    $totalCredits += $matiere->credit;
                    $moyCreds += !is_null($note) ? (!is_null($moyenne) ? ($moyenne * $matiere->credit) : 0) : 0;
                    $totalCoefficients += $matiere->coefficient;
                    $sommeMoyenne += !is_null($note) ? $moyenne : 0;
                    $nbrMatiere++;
                }
            }
            count($uniteEnseignementCourante) > 1 ? array_push($ues, $uniteEnseignementCourante) : '';
        }

        $moyennFinale = $sommeMoyenne / $nbrMatiere;
        if($semestre == 2) {
            $dataSemestre1 = $this->moyenneSemestre1($classe, $anneeAcademique->id, $etudiant->id, $session);
            $moyenneFinaleSemestre1 = $dataSemestre1[0];
            $creditValideesSemestre1 = $dataSemestre1[1];
            $TotalCreditsSemestre1 = $dataSemestre1[2];
            $moyenneAnnuelle = ($moyennFinale + $moyenneFinaleSemestre1) / 2;
        }

        $bulletinDatas = [
            'anneeAcademique' => $anneeAcademique->debut . ' - ' . $anneeAcademique->fin,
            'semestre' => $semestre,
            'session' => $session,
            'faculte' => $classe->niveauFaculte->faculte->nom,
            'fullname' => $etudiant->fullname,
            'statut' => $etudiant->statut,
            'sexe' => $etudiant->sexe,
            'dateNais' => $etudiant->date_naissance->format('d/m/Y'),
            'lieuNais' => $etudiant->lieu_naissance,
            'matricule_etudiant' => $etudiant->matricule_etudiant,
            'classe' => $classe->nom,
            'unite_enseignements' => $ues,
            'moyenne_semestre' => $totalCredits,
            'total_coefficient' => $totalCoefficients,
            'resultat_final' => $totalCreditValidee == $totalCredits ? 'Semestre Validé' : 'Semestre non Validé',
            'mention_finale' => $this->mention($moyennFinale),
            'moyenne_finale' => $moyennFinale,
            'moyenne_semestre_1' => $semestre == 2 ? $moyenneFinaleSemestre1 : '',
            'credits_validee_semestre_1' => $semestre == 2 ? $creditValideesSemestre1 : '',
            'total_credits_semestre_1' => $semestre == 2 ? $TotalCreditsSemestre1 : '',
            'resultat_semestre_1' => $semestre == 2 ? ($creditValideesSemestre1 == $TotalCreditsSemestre1 ? 'Semestre validé' : 'Semestre Non validé') : '',
            'moyenne_annelle' => $semestre == 2 ? $moyenneAnnuelle : 0,
            'total_credit_validee' => $totalCreditValidee,
            'total_credit' => $totalCredits,
            'etudiant_id' => $etudiant->id,
            'identifiant_bulletin' => $etudiant->identifiant_bulletin . '/R/SG/INFO',
        ];

        return $bulletinDatas;
    }

    public function bulletinEtudiantOld($etudiantId, $semestre, $session) {
        $etudiant = User::findOrFail($etudiantId);
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $classe = $etudiant->classe($anneeAcademique->id);
        $uniteEnseignements = array_unique(array_column($classe->uniteEnseignements->toArray(), 'nom'));
        $bulletinDatas = [];
        
        $totalCreditValidee = 0;
        $totalCredits = 0;
        $totalCoefficients = 0;
        $moyCreds = 0;
        $sommeMoyenne = 0;
        $nbrMatiere = 0;
        $ues = [];

        foreach ($uniteEnseignements as $uniteEnseignement) {
            $uniteEnseignementCourante = [];
            $uniteEnseignementCourante['nom'] = $uniteEnseignement;

            foreach($classe->matieres->where('semestre', $semestre)->sortBy('numero_ordre') as $matiere) {
                if($uniteEnseignement == $matiere->uniteEnseignement->nom) {
                    $note = Note::with('professeur')->where('annee_academique_id', $anneeAcademique->id)
                        ->where('matiere_id', $matiere->id)
                        ->where('classe_id', $classe->id)
                        ->where('user_id', $etudiant->id)
                        ->first();
                    
                        // if($session == 1) {
                        //     if(!is_null($note)) {
                        //         $moyenne = $note->moyenne ?? 0;
                        //     }
                        //     else {
                        //         $moyenne = 0;
                        //     }
                        // } else {
                        //     if(!is_null($note)) {
                        //         if(($note->partiel_session_1 < 10 || $note->partiel_session_1 == "NONE") && $note->moyenne < 10)
                        //         {
                        //             $moyenne = $note->partiel_session_2 ?? 0;
                        //         }
                        //         else {
                        //             $moyenne = $note->moyenne ?? 0;
                        //         }
                        //     }
                        //     else {
                        //         $moyenne = 0;
                        //     }
                        // }
                    if ($session == 1) {
                        $moyenne = $note ? ($note->moyenne ?? 0) : 0;
                    } else {
                        // if ($note && ($note->partiel_session_1 < 10 || $note->partiel_session_1 == "NONE" || $note->moyenne < 10)) {
                        if ($note && $note->moyenne < 10) {
                            $moyenne = $note->partiel_session_2 ?? 0;
                        } else {
                            $moyenne = $note ? ($note->moyenne ?? 0) : 0;
                        }
                    }

                    array_push($uniteEnseignementCourante ,[
                        'matiere' => $matiere->nom,
                        'coefficient' => $matiere->coefficient,
                        'credit' => $matiere->credit,
                        'credit_moyenne' => $matiere->credit * $moyenne,
                        'moyenne' => $this->nombreFormatDeuxDecimal($moyenne),
                        'moyCred' => !is_null($note) ? (!is_null($moyenne) ? ($moyenne * $matiere->credit) : 0) : 0,
                        'resultat' => !is_null($note) ? (!is_null($moyenne) ? ($moyenne >= 10 ? 'Validée' : 'Non validée') : 'Non validée') : 'Non validée',
                        'mention' => !is_null($note) ? $this->mention($moyenne) : $this->mention(0),
                        'nom_professeur' => !is_null($note) ? $note->professeur->fullname : 'Nom professeur',
                    ]);
                    !is_null($note) ? (!is_null($moyenne) ? ($moyenne >= 10 ? $totalCreditValidee += $matiere->credit : $totalCreditValidee += 0) : '') : '';
                    $totalCredits += $matiere->credit;
                    $moyCreds += !is_null($note) ? (!is_null($moyenne) ? ($moyenne * $matiere->credit) : 0) : 0;
                    $totalCoefficients += $matiere->coefficient;
                    $sommeMoyenne += !is_null($note) ? $moyenne : 0;
                    $nbrMatiere++;
                }
            }
            count($uniteEnseignementCourante) > 1 ? array_push($ues, $uniteEnseignementCourante) : '';
        }

        $moyennFinale = $sommeMoyenne / $nbrMatiere;
        if($semestre == 2) {
            $dataSemestre1 = $this->moyenneSemestre1($classe, $anneeAcademique->id, $etudiant->id, $session);
            $moyenneFinaleSemestre1 = $dataSemestre1[0];
            $creditValideesSemestre1 = $dataSemestre1[1];
            $TotalCreditsSemestre1 = $dataSemestre1[2];
            $moyenneAnnuelle = ($moyennFinale + $moyenneFinaleSemestre1) / 2;
        }

        $bulletinDatas = [
            'anneeAcademique' => $anneeAcademique->debut . ' - ' . $anneeAcademique->fin,
            'semestre' => $semestre,
            'session' => $session,
            'faculte' => $classe->niveauFaculte->faculte->nom,
            'fullname' => $etudiant->fullname,
            'dateNais' => $etudiant->date_naissance->format('d/m/Y'),
            'lieuNais' => $etudiant->lieu_naissance,
            'matricule_etudiant' => $etudiant->matricule_etudiant,
            'classe' => $classe->nom,
            'unite_enseignements' => $ues,
            'moyenne_semestre' => $totalCredits,
            'total_coefficient' => $totalCoefficients,
            'resultat_final' => $totalCreditValidee == $totalCredits ? 'Semestre Validé' : 'Semestre non Validé',
            'mention_finale' => $this->mention($moyennFinale),
            'moyenne_finale' => $moyennFinale,
            'moyenne_semestre_1' => $semestre == 2 ? $moyenneFinaleSemestre1 : '',
            'credits_validee_semestre_1' => $semestre == 2 ? $creditValideesSemestre1 : '',
            'total_credits_semestre_1' => $semestre == 2 ? $TotalCreditsSemestre1 : '',
            'resultat_semestre_1' => $semestre == 2 ? ($creditValideesSemestre1 == $TotalCreditsSemestre1 ? 'Semestre validé' : 'Semestre Non validé') : '',
            'moyenne_annelle' => $semestre == 2 ? $moyenneAnnuelle : '',
            'total_credit_validee' => $totalCreditValidee,
            'total_credit' => $totalCredits,
            'etudiant_id' => $etudiant->id,
            'identifiant_bulletin' => $etudiant->identifiant_bulletin . '/R/SG/INFO',
        ];

        return $bulletinDatas;
    }

    public function pv($classe, $semestre, $session) {

        $classe = Classe::findOrFail($classe);
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $uniteEnseignements = [];
        $uniteEnseignementAll = [];

        $entetes = [];
        $entete1 = [];
        $totalCreditUe = 0;

        if ($session == 1) {
            $identifiant['colspan'] = 1;
            $identifiant['rowspan'] = 3;
            $identifiant['nom'] = 'IDENTIFICATION DE L’ETUDIANT (matricule)';
    
            $entete2 = [];
            $unEns['colspan'] = 1;
            $unEns['rowspan'] = 1;
            $unEns['nom'] = 'UE';

            $entete3 = [];
            array_push($entete3, [
                'colspan' => 1,
                'rowspan' => 2,
                'nom' => "NOMS ET PRENOMS (date et lieu de naissance)",
            ]);
    
            $entete4 = [];
            array_push($entete2, $unEns);
            
            $ueData = $classe->UeMatieres($semestre);
            $UeMatieres = $ueData[0];
            $totalCreditUe = $ueData[1];
            foreach($UeMatieres as $ue => $matieres) {
                array_push($entete2, [
                    'colspan' => (count($matieres) * 3) + 2,
                    'rowspan' => 1,
                    'nom' => $ue,
                ]);

                foreach($matieres as $matiere) {
                    array_push($entete3, [
                        'colspan' => 3,
                        'rowspan' => 1,
                        'nom' => $matiere,
                    ]);
                    $entete4[] = 'TD';
                    $entete4[] = 'EXAM';
                    $entete4[] = 'MOY.ECUE';
                }

                array_push($entete3, [
                    'colspan' => 1,
                    'rowspan' => 2,
                    'nom' => "MOY.UE",
                ], [
                    'colspan' => 1,
                    'rowspan' => 2,
                    'nom' => "RES.UE",
                ]);
            }

            array_push($entete3, [
                'colspan' => 1,
                'rowspan' => 1,
                'nom' => "UE",
            ], [
                'colspan' => 1,
                'rowspan' => 1,
                'nom' => "CREDIT(S)",
            ]);

            $entete4[] = count($UeMatieres);
            $entete4[] = $totalCreditUe;

            array_push($entete2, [
                'colspan' => 2,
                'rowspan' => 1,
                'nom' => 'RESULTATS DU SEMESTRE',
            ], [
                'colspan' => 1,
                'rowspan' => 3,
                'nom' => 'DECISION',
            ]);   
            
            array_push($entete1, [
                'colspan' => array_sum(array_column($entete2, 'colspan')),
                'rowspan' => 1,
                'nom' => 'PV DE DELIBERATION SESSION ' . $session . ' / SEMESTRE '. $semestre . ' - ' . $classe->nom,
            ]);
    
            array_push($entetes, $entete1, $entete2, $entete3, $entete4);
    
            $dataAllEtudiants = [];
            foreach ($classe->etudiants() as $etudiant) {
                $etudiantDatas = [];
                $etudiantDatas[] = $etudiant->fullname . ' Né(e) le ' . $etudiant->date_naissance->format('d/m/Y') . ' à ' . $etudiant->lieu_naissance;
                
                $totalCreditValidee = 0;

                $ueMatieres = $classe->matieres
                    ->sortBy('numero_ordre')
                    ->where('semestre', $semestre)
                    ->groupBy('uniteEnseignement.nom')
                    ->toArray();
                
                $totalUeValidees = 0;
                foreach($ueMatieres as $ueMatiere) {
                    $moyCreditUe = 0;
                    $moyenneUe = 0;
                    $sommeCreditUe = 0;

                    foreach($ueMatiere as $matiere) {
                        $note = Note::with('professeur')->where('annee_academique_id', $anneeAcademique->id)
                            ->where('matiere_id', $matiere['id'])
                            ->where('classe_id', $classe->id)
                            ->where('user_id', $etudiant->id)
                            ->first();

                        if(!is_null($note)) {
                            $moyenTD = 0;
                            $diviseur = in_array('partiel_session_1', $note->notes_selectionnees ?? []) ? (count($note->notes_selectionnees) - 1) : count($note->notes_selectionnees);
                            
                            if (!is_null($note->notes_selectionnees) && count($note->notes_selectionnees) !== 0) {
                                $sommeNote = 0;
                                foreach($note->notes_selectionnees as $note_x) {
                                    $note_x == 'note_1' ? $sommeNote += $note->note_1 : '';
                                    $note_x == 'note_2' ? $sommeNote += $note->note_2 : '';
                                    $note_x == 'note_3' ? $sommeNote += $note->note_3 : '';
                                    $note_x == 'note_4' ? $sommeNote += $note->note_4 : '';
                                    $note_x == 'note_5' ? $sommeNote += $note->note_5 : '';
                                    $note_x == 'note_6' ? $sommeNote += $note->note_6 : '';
                                }
        
                                $moyenTD = $diviseur !== 0 ? ($sommeNote / $diviseur) : 0;
                            }
                        }

                        $etudiantDatas[] = !is_null($note) ? number_format($moyenTD, 2) : 0;
                        $etudiantDatas[] = !is_null($note) ? $note->partiel_session_1 : 0;
                        $etudiantDatas[] = !is_null($note) ? $this->nombreFormatDeuxDecimal($note->moyenne) : 0;
                        
                        $moyCreditUe += !is_null($note) ? $note->moyenne * $matiere['credit'] : 0;
                        $sommeCreditUe += $matiere['credit'];
                        !is_null($note) ? ($note->moyenne >= 10 ? $totalCreditValidee += $matiere['credit'] : $totalCreditValidee += 0) : $totalCreditValidee += 0  ;
                    }

                    $moyenneUe = $moyCreditUe / $sommeCreditUe;
                    $etudiantDatas[] = $this->nombreFormatDeuxDecimal($moyenneUe);
                    $etudiantDatas[] = $moyenneUe >= 10 ? 'V' : 'R';

                    $totalUeValidees += $moyenneUe >= 10 ? 1 : 0;

                }

                $etudiantDatas[] = $totalUeValidees . '/' . count($ueMatieres);
                $etudiantDatas[] = $totalCreditValidee . '/' . $totalCreditUe;
                $etudiantDatas[] = $totalUeValidees == count($ueMatieres) ? 'ADMIS' : 'AJOURNE';

                array_push($dataAllEtudiants, $etudiantDatas);
            }
        }
        else {
            $identifiant['colspan'] = 1;
            $identifiant['rowspan'] = 3;
            $identifiant['nom'] = 'IDENTIFICATION DE L’ETUDIANT (matricule)';
    
            $entete2 = [];
            $unEns['colspan'] = 1;
            $unEns['rowspan'] = 1;
            $unEns['nom'] = 'UE';

            $entete3 = [];
            array_push($entete3, [
                'colspan' => 1,
                'rowspan' => 2,
                'nom' => "NOMS ET PRENOMS (date et lieu de naissance)",
            ]);
    
            $entete4 = [];
            array_push($entete2, $unEns);
            
            $ueData = $classe->UeMatieres($semestre);
            $UeMatieres = $ueData[0];
            $totalCreditUe = $ueData[1];
            foreach($UeMatieres as $ue => $matieres) {
                array_push($entete2, [
                    'colspan' => (count($matieres) * 3) + 2,
                    'rowspan' => 1,
                    'nom' => $ue,
                ]);

                foreach($matieres as $matiere) {
                    array_push($entete3, [
                        'colspan' => 3,
                        'rowspan' => 1,
                        'nom' => $matiere,
                    ]);
                    $entete4[] = 'TD';
                    $entete4[] = 'EXAM';
                    $entete4[] = 'MOY.ECUE';
                }

                array_push($entete3, [
                    'colspan' => 1,
                    'rowspan' => 2,
                    'nom' => "MOY.UE",
                ], [
                    'colspan' => 1,
                    'rowspan' => 2,
                    'nom' => "RES.UE",
                ]);
            }

            array_push($entete3, [
                'colspan' => 1,
                'rowspan' => 1,
                'nom' => "UE",
            ], [
                'colspan' => 1,
                'rowspan' => 1,
                'nom' => "CREDIT(S)",
            ]);

            $entete4[] = count($UeMatieres);
            $entete4[] = $totalCreditUe;

            array_push($entete2, [
                'colspan' => 2,
                'rowspan' => 1,
                'nom' => 'RESULTATS DU SEMESTRE',
            ], [
                'colspan' => 1,
                'rowspan' => 3,
                'nom' => 'DECISION',
            ]);   
            
            array_push($entete1, [
                'colspan' => array_sum(array_column($entete2, 'colspan')),
                'rowspan' => 1,
                'nom' => 'PV DE DELIBERATION SESSION ' . $session . ' / SEMESTRE '. $semestre . ' - ' . $classe->nom,
            ]);
    
            array_push($entetes, $entete1, $entete2, $entete3, $entete4);
    
            $dataAllEtudiants = [];
            // Récupère tous les étudiants dont partiel_session_2 n'est pas null
            $req = Note::query()
                ->with('etudiant')
                ->whereNotNull('partiel_session_2')
                ->where('moyenne', '<', 10)
                ->where('annee_academique_id', $anneeAcademique->id)
                ->where('classe_id', $classe->id)
                ->distinct('user_id')
                ->get(['user_id']);
            
            $etudiantSession2 = User::query()
                ->whereIn('id', $req->pluck('user_id'))
                ->orderBy('fullname')
                ->get();

            foreach ($etudiantSession2 as $etudiant) {
                $etudiantDatas = [];
                $etudiantDatas[] = $etudiant->fullname . ' Né(e) le' . $etudiant->date_naissance->format('d/m/Y') . ' à ' . $etudiant->lieu_naissance;
                
                $totalCreditValidee = 0;

                $ueMatieres = $classe->matieres
                    ->sortBy('numero_ordre')
                    ->where('semestre', $semestre)
                    ->groupBy('uniteEnseignement.nom')
                    ->toArray();
                
                $totalUeValidees = 0;
    
                foreach($ueMatieres as $ueMatiere) {
                    $moyCreditUe = 0;
                    $moyenneUe = 0;
                    $sommeCreditUe = 0;

                    foreach($ueMatiere as $matiere) {
                        $note = Note::with('professeur')->where('annee_academique_id', $anneeAcademique->id)
                            ->where('matiere_id', $matiere['id'])
                            ->where('classe_id', $classe->id)
                            ->where('user_id', $etudiant->id)
                            ->first();

                        if(!is_null($note)) {
                            if($note->moyenne >= 10) {
                                $etudiantDatas[] = !is_null($note) ? '-' : '-';
                                $etudiantDatas[] = !is_null($note) ? '-' : '-';
                                $etudiantDatas[] = !is_null($note) ? '-' : '-';

                                $moyCreditUe += !is_null($note) ? $note->moyenne * $matiere['credit'] : 0;
                                !is_null($note) ? ($note->moyenne >= 10 ? $totalCreditValidee += $matiere['credit'] : $totalCreditValidee += 0) : $totalCreditValidee += 0  ;

                            }
                            else {
                                $etudiantDatas[] = !is_null($note) ? '-' : 0;
                                $etudiantDatas[] = !is_null($note) ? $this->nombreFormatDeuxDecimal($note->partiel_session_2) : 0;
                                $etudiantDatas[] = !is_null($note) ? $this->nombreFormatDeuxDecimal($note->partiel_session_2) : 0;

                                $moyCreditUe += !is_null($note) ? $note->partiel_session_2 * $matiere['credit'] : 0;
                                !is_null($note) ? ($note->partiel_session_2 >= 10 ? $totalCreditValidee += $matiere['credit'] : $totalCreditValidee += 0) : $totalCreditValidee += 0  ;
                            }
                        }
                        
                        $sommeCreditUe += $matiere['credit'];
                    }

    
                    $moyenneUe = $moyCreditUe / $sommeCreditUe;
                    $etudiantDatas[] = $this->nombreFormatDeuxDecimal($moyenneUe);
                    $etudiantDatas[] = $moyenneUe >= 10 ? 'V' : 'R';

                    $totalUeValidees += $moyenneUe >= 10 ? 1 : 0;

                }

                $etudiantDatas[] = $totalUeValidees . '/' . count($ueMatieres);
                $etudiantDatas[] = $totalCreditValidee . '/' . $totalCreditUe;
                $etudiantDatas[] = $totalUeValidees == count($ueMatieres) ? 'ADMIS' : 'AJOURNE';

                // $etudiantDatas[] = $totalCreditValidee;
                array_push($dataAllEtudiants, $etudiantDatas);
            }
        }

        return [$entetes, $dataAllEtudiants];
    }

    public function pvOld($classe, $semestre, $session) {

        $classe = Classe::findOrFail($classe);
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $uniteEnseignements = [];
        $uniteEnseignementAll = [];

        $entetes = [];
        $entete1 = [];
        
        if ($session == 1) {
            $identifiant['colspan'] = 1;
            $identifiant['rowspan'] = 3;
            $identifiant['nom'] = 'IDENTIFICATION DE L’ETUDIANT (matricule)';
    
            $unitEns['colspan'] = 1;
            $unitEns['rowspan'] = 1;
            $unitEns['nom'] = 'UE';
    
            $entete2 = [];
            $ecue['colspan'] = 1;
            $ecue['rowspan'] = 2;
            $ecue['nom'] = 'ECUE';
    
            $entete4 = [];
            $entete4[] = 'NOMS ET PRENOMS';
            $entete4[] = 'STATUS';
            $totalCredits = 0;
            array_push($entete2, $ecue);
    
            foreach($classe->matieres->sortBy('numero_ordre')->where('semestre', $semestre) as $matiere) {
    
                // Récupérer l'UE de chaque matière
                $uniteEnseignementAll[] = $matiere->uniteEnseignement->nom;
                if(!in_array($matiere->uniteEnseignement->nom, $uniteEnseignements))
                    $uniteEnseignements[] = $matiere->uniteEnseignement->nom;
    
                array_push($entete2, [
                    'colspan' => 2,
                    'rowspan' => 2,
                    'nom' => $matiere->nom,
                ]);
                array_push($entete2, [
                    'colspan' => 1,
                    'rowspan' => 3,
                    'nom' => 'MOY.ECUE',
                ]);
                array_push($entete2, [
                    'colspan' => 1,
                    'rowspan' => 3,
                    'nom' => 'CREDIT(S)',
                ]);
                $entete4[] = 'TD';
                $entete4[] = 'EXAM';
    
                $totalCredits += $matiere->credit;
            }
    
            $ues = array_count_values($uniteEnseignementAll);
            
            array_push($entete1, $identifiant, $unitEns);
    
            foreach ($ues as $ue => $colspan) {
                array_push($entete1, [
                    'colspan' => $colspan * 4,
                    'rowspan' => 1,
                    'nom' => $ue,
                ]);
            }
    
            $entete3 = [];
            array_push($entete3, [
                "colspan" => 1,
                "rowspan" => 1,
                "nom" => "TOTAL CREDIT VALIDE  / " . $totalCredits,
            ]);
            array_push($entetes, $entete1, $entete2, $entete3);
    
            $dataAllEtudiants = [];
            foreach ($classe->etudiants() as $etudiant) {
                $etudiantDatas = [];
                $etudiantDatas[] = $etudiant->fullname;
                $etudiantDatas[] = $etudiant->statut;
                $totalCreditValidee = 0;
    
                foreach($classe->matieres->where('semestre', $semestre)->sortBy('numero_ordre')->where('semestre', $semestre) as $matiere) {
                    $note = Note::with('professeur')->where('annee_academique_id', $anneeAcademique->id)
                        ->where('matiere_id', $matiere->id)
                        ->where('classe_id', $classe->id)
                        ->where('user_id', $etudiant->id)
                        ->first();
    
                    if (!is_null($note)) {
                        $moyenTD = 0;
                        // J'ai ajouter un tableau vide dans le in_array ci dessous, cela semble fonctionner mais je ne sais si cela
                        // va créer d'autres soucis après. Je regarde seulement.
                        $diviseur = in_array('partiel_session_1', $note->notes_selectionnees ?? []) ? (count($note->notes_selectionnees) - 1) : count($note->notes_selectionnees);
                        if (!is_null($note->notes_selectionnees) && count($note->notes_selectionnees) !== 0) {
                            $sommeNote = 0;
                            foreach($note->notes_selectionnees as $note_x) {
                                $note_x == 'note_1' ? $sommeNote += $note->note_1 : '';
                                $note_x == 'note_2' ? $sommeNote += $note->note_2 : '';
                                $note_x == 'note_3' ? $sommeNote += $note->note_3 : '';
                                $note_x == 'note_4' ? $sommeNote += $note->note_4 : '';
                                $note_x == 'note_5' ? $sommeNote += $note->note_5 : '';
                                $note_x == 'note_6' ? $sommeNote += $note->note_6 : '';
                            }
    
                            $moyenTD = $diviseur !== 0 ? ($sommeNote / $diviseur) : 0;
                        }
                    }
    
                    $etudiantDatas[] = !is_null($note) ? number_format($moyenTD, 2) : 0;
                    $etudiantDatas[] = !is_null($note) ? $note->partiel_session_1 : 0;
                    $etudiantDatas[] = !is_null($note) ? $note->moyenne : 0;
                    $etudiantDatas[] = $matiere->credit ?? 0;
                    !is_null($note) ? ($note->moyenne >= 10 ? $totalCreditValidee += $matiere->credit : $totalCreditValidee += 0) : $totalCreditValidee += 0  ;
                }
                $etudiantDatas[] = $totalCreditValidee;
                array_push($dataAllEtudiants, $etudiantDatas);
            }
        }
        else {
            $identifiant['colspan'] = 1;
            $identifiant['rowspan'] = 3;
            $identifiant['nom'] = 'IDENTIFICATION DE L’ETUDIANT (matricule)';
    
            $unitEns['colspan'] = 1;
            $unitEns['rowspan'] = 1;
            $unitEns['nom'] = 'UE';
    
            $entete2 = [];
            $ecue['colspan'] = 1;
            $ecue['rowspan'] = 2;
            $ecue['nom'] = 'ECUE';
    
            $entete4 = [];
            $entete4[] = 'NOMS ET PRENOMS';
            $entete4[] = 'STATUS';
            $totalCredits = 0;
            array_push($entete2, $ecue);
    
            foreach($classe->matieres->sortBy('numero_ordre')->where('semestre', $semestre) as $matiere) {
    
                // Récupérer l'UE de chaque matière
                $uniteEnseignementAll[] = $matiere->uniteEnseignement->nom;
                if(!in_array($matiere->uniteEnseignement->nom, $uniteEnseignements))
                    $uniteEnseignements[] = $matiere->uniteEnseignement->nom;
    
                array_push($entete2, [
                    'colspan' => 2,
                    'rowspan' => 2,
                    'nom' => $matiere->nom,
                ]);
                array_push($entete2, [
                    'colspan' => 1,
                    'rowspan' => 3,
                    'nom' => 'MOY.ECUE',
                ]);
                array_push($entete2, [
                    'colspan' => 1,
                    'rowspan' => 3,
                    'nom' => 'CREDIT(S)',
                ]);
                $entete4[] = 'TD';
                $entete4[] = 'EXAM';
    
                $totalCredits += $matiere->credit;
            }
    
            $ues = array_count_values($uniteEnseignementAll);
            
            array_push($entete1, $identifiant, $unitEns);
    
            foreach ($ues as $ue => $colspan) {
                array_push($entete1, [
                    'colspan' => $colspan * 4,
                    'rowspan' => 1,
                    'nom' => $ue,
                ]);
            }
    
            $entete3 = [];
            array_push($entete3, [
                "colspan" => 1,
                "rowspan" => 1,
                "nom" => "TOTAL CREDIT VALIDE  / " . $totalCredits,
            ]);
            array_push($entetes, $entete1, $entete2, $entete3);
    
            $dataAllEtudiants = [];
            // Récupère tous les étudiants dont partiel_session_2 n'est pas null

            // $etudiantSession2 = $classe->etudiants()
            //     ->whereHas('notes', function ($query) use ($anneeAcademique) {
            //         $query->whereNotNull('partiel_session_2')
            //             ->where('moyenne', '<', 10)
            //             ->where('annee_academique_id', $anneeAcademique->id);
            //     })
            //     ->orderBy('fullname')
            //     ->get();

            // $etudiantSession2 = Note::with('etudiant')
            //     ->whereNotNull('partiel_session_2')
            //     ->where('moyenne', '<', 10)
            //     ->where('annee_academique_id', $anneeAcademique->id)
            //     ->where('classe_id', $classe->id)
            //     ->get()
            //     ->pluck('etudiant')
            //     ->unique()
            //     ->sortBy('fullname');

            $req = Note::query()
                ->with('etudiant')
                ->whereNotNull('partiel_session_2')
                ->where('moyenne', '<', 10)
                ->where('annee_academique_id', $anneeAcademique->id)
                ->where('classe_id', $classe->id)
                ->distinct('user_id')
                ->get(['user_id']);
            
            $etudiantSession2 = User::query()
                ->whereIn('id', $req->pluck('user_id'))
                ->orderBy('fullname')
                ->get();

            foreach ($etudiantSession2 as $etudiant) {
                $etudiantDatas = [];
                $etudiantDatas[] = $etudiant->fullname;
                $etudiantDatas[] = $etudiant->statut;
                $totalCreditValidee = 0;
    
                foreach($classe->matieres->where('semestre', $semestre)->sortBy('numero_ordre') as $matiere) {
                    $note = Note::with('professeur')->where('annee_academique_id', $anneeAcademique->id)
                        ->where('matiere_id', $matiere->id)
                        ->where('classe_id', $classe->id)
                        ->where('user_id', $etudiant->id)
                        ->first();
    
                    if(!is_null($note)) {
                        if($note->moyenne >= 10) {
                            $etudiantDatas[] = !is_null($note) ? '-' : 0;
                            $etudiantDatas[] = !is_null($note) ? '-' : '-';
                            $etudiantDatas[] = !is_null($note) ? '-' : '-';
                            $etudiantDatas[] = !is_null($note->partiel_session_2) ? '-' : '-';
                        }
                        else {
                            $etudiantDatas[] = !is_null($note) ? '-' : 0;
                            $etudiantDatas[] = !is_null($note) ? (!is_null($note->partiel_session_2) ? $note->partiel_session_2 : '-') : '-';
                            $etudiantDatas[] = !is_null($note) ? (!is_null($note->partiel_session_2) ? $note->partiel_session_2 : '-') : '-';
                            $etudiantDatas[] = !is_null($note->partiel_session_2) ? $matiere->credit : '-';
                        }
                    }

                    !is_null($note) ? (!is_null($note->partiel_session_2) ? ($note->partiel_session_2 >= 10 ? $totalCreditValidee += $matiere->credit : $totalCreditValidee += 0) : '') : '';                    
                }

                $etudiantDatas[] = $totalCreditValidee;
                array_push($dataAllEtudiants, $etudiantDatas);
            }
        }

        return [$entetes, $dataAllEtudiants, $entete4];
    }

}
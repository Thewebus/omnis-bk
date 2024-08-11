<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Note;
use App\Models\Test;
use App\Models\User;
use App\Models\Cours;
use App\Models\Faculte;
use App\Models\Filiere;
use App\Models\Matiere;
use setasign\Fpdi\Fpdi;
use App\Models\Personnel;
use App\Models\Scolarite;
use App\Models\Professeur;
use App\Models\Inscription;
use App\Models\HeureAbsence;
use Illuminate\Http\Request;
use App\Models\NiveauFiliere;
use App\Models\ResourcesCours;
use App\Models\AnneeAcademique;
use Illuminate\Validation\Rule;
use App\Models\MatiereProfesseur;
use App\Services\ScheduleService;
use App\Services\OtherDataService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\InscriptionTest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\HimSelfEtudiantStoreRequest;
use App\Http\Requests\HimSelfEtudiantUpdateRequest;

class EtudiantController extends Controller
{
    public $anneeAcademique;

    public function __construct() {
        // $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $this->anneeAcademique = AnneeAcademique::find(1);
    }

    public function dashboard() {
        $anneeAcademique = $this->anneeAcademique;
        $etudiant = User::findOrFail(Auth::id());
        if(isset($etudiant->classe($anneeAcademique->id)->niveauFaculte->matieres) && $etudiant->classe($anneeAcademique->id) !== null) {
            $dataDash = [];
            $dataProgressionCours = [];
            $dataNotes = [];
    
            $dataDash['matiere'] = $etudiant->classe($anneeAcademique->id)->niveauFaculte->matieres->count();
            $dataDash['heure_absence'] = HeureAbsence::where('annee_academique_id', $anneeAcademique->id)->where('user_id', Auth::id())->sum('heure_absence');
            $dataDash['scolarite_montant'] = Auth::user()->inscriptions->last()->net_payer;
            $dataDash['scolarite_payee'] = Scolarite::where('annee_academique_id', $anneeAcademique->id)->where('user_id', Auth::id())->sum('payee');
            $dataDash['scolarite_rest'] = $dataDash['scolarite_montant'] - $dataDash['scolarite_payee'];
            $dataDash['scolarite_pourcentage'] = ($dataDash['scolarite_payee'] * 100) / $dataDash['scolarite_montant'];
    
            $notes = Note::where('annee_academique_id', $anneeAcademique->id)->where('user_id', Auth::id())->orderBy('created_at', 'DESC')->take(4)->get();
            foreach ($notes as $note) {
                $dataNote = [];
                $matiere = Matiere::findOrFail($note->matiere_id);
                $dataNote['nom_matiere'] = $matiere->nom;
                if(!is_null($note->note_3)) {
                    $dataNote['note'] = $note->note_3;
                }
                elseif (!is_null($note->note_2)) {
                    $dataNote['note'] = $note->note_2;
                }
                else {
                    $dataNote['note'] = $note->note_1;
                }
    
                array_push($dataNotes, $dataNote);
            }
    
            $matiereProfesseurs = MatiereProfesseur::with('professeur', 'matiere')->where('annee_academique_id', $anneeAcademique->id)
                ->where('classe_id', $etudiant->classe($anneeAcademique->id)->id)
                ->where('progression', '!=', 0)
                ->orderBy('updated_at', 'DESC')->take(6)->get();
    
            foreach ($matiereProfesseurs as $matiereProfesseur) {
                array_push($dataProgressionCours, [
                    'nom_professeur' => $matiereProfesseur->professeur->fullname,
                    'nom_matiere' => $matiereProfesseur->matiere->nom,
                    'volume_horaire' => $matiereProfesseur->volume_horaire,
                    'progression' => $matiereProfesseur->progression,
                    'statut' => $matiereProfesseur->statut,
                    'pourcentage' => ($matiereProfesseur->progression * 100) / $matiereProfesseur->volume_horaire,
                ]);
            }        
    
            return view('etudiant.dashboard', compact('dataDash', 'dataNotes', 'dataProgressionCours', 'anneeAcademique', 'etudiant'));

        }
        else {

            return view('etudiant.dashboard');
        }
    }

    public function inscription() {
        return view('etudiant.inscription');
    }

    public function storeInscription(HimSelfEtudiantStoreRequest $request) {
        if (!is_null($request->fiche_inscription)) {
            $fiche_inscription_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_fiche_inscription.' . $request->fiche_inscription->extension();
            $fiche_inscription_path = $request->fiche_inscription->storeAs('public/etudiants/fiche-inscription', $fiche_inscription_name);
        }
        if (!is_null($request->fiche_oriantation)) {
            $fiche_oriantation_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . 'fiche_oriantation.' . $request->fiche_oriantation->extension();
            $fiche_oriantation_path = $request->fiche_inscription->storeAs('public/etudiants/fiche-orientation', $fiche_oriantation_name);
        }
        if (!is_null($request->extrait_naissance)) {
            $extrait_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_extrait_naissance.' . $request->extrait_naissance->extension();
            $extrait_path = $request->extrait_naissance->storeAs('public/etudiants/extrait-naissance', $extrait_name);
        }
        if (!is_null($request->bac_legalise)) {
            $bac_legalise_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_bac_legalise.' . $request->bac_legalise->extension();
            $bac_legalise_path = $request->bac_legalise->storeAs('public/etudiants/bac', $bac_legalise_name);
        }
        if (!is_null($request->cp_note_bac)) {
            $cp_note_bac_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_cp_note_bac.' . $request->cp_note_bac->extension();
            $cp_note_bac_path = $request->cp_note_bac->storeAs('public/etudiants/note-bac', $cp_note_bac_name);
        }
        if (!is_null($request->photo)) {
            $photo_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_photo.' . $request->photo->extension();
            $photo_path = $request->photo->storeAs('public/etudiants/photo', $photo_name);
        }

        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();

        Auth::user()->update([
            'fullname' => $request->nom_complet,
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'numero_etudiant' => $request->numero,
            'email' => $request->email,
            'sexe' => $request->sexe,
            // 'statut' => $request->statut,
            // 'password' => "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi",
            'nationalite' => $request->nationalite,
            // 'matricule_etudiant' => $request->matricule,
            'domicile' => $request->domicile,
            'etablissement_origine' => $request->etablissement_origine,
            'adresse_geographique' => $request->adresse_geographique,
            'niveau_etude' => $request->niveau_etude,
            'autre_diplome' => $request->autre_diplome,
            'serie_bac' => $request->serie_bac,
            'premier_entree_ua' => $request->date_premiere_entree,
            'responsable_legal' => $request->responsable_legal,
            'responsable_legal_precision' => $request->responsable_legal_precision,
            'responsable_legal_fullname' => $request->responsable_legal_fullname,
            'responsable_legal_profession' => $request->responsable_legal_profession,
            'responsable_legal_adresse' => $request->responsable_legal_adresse,
            'responsable_legal_domicile' => $request->responsable_legal_domicile,
            'responsable_legal_numero' => $request->responsable_legal_numero,
            // 'classe_id' => $request->classe,
            'photo' => $photo_path ?? null,
        ]);
        
        Inscription::create([
            'fiche_inscription' => $fiche_inscription_path ?? null,
            'fiche_oriantation' => $fiche_oriantation_path ?? null,
            'extrait_naissance' => $extrait_path ?? null,
            'bac_legalise' => $bac_legalise_path ?? null,
            'cp_note_bac' => $cp_note_bac_path ?? null,
            'photo' => $photo_path ?? null,
            'user_id' => Auth::id(),
            'annee_academique_id' => $anneeAcademique->id,
        ]);

        $success = true;
        return redirect()->back()->withSuccess('success');
    }

    public function updateInscription(HimSelfEtudiantUpdateRequest $request) {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $inscription = Inscription::where('annee_academique_id', $anneeAcademique->id)->where('user_id', Auth::id())->first();

        if (is_null($inscription)) {
            if (!is_null($request->fiche_inscription)) {
                $fiche_inscription_name = str_replace(' ', '_', $request->nom_prenom_etudiant). '_' . time() . '_fiche_inscription.' . $request->fiche_inscription->extension();
                $fiche_inscription_path = $request->fiche_inscription->storeAs('public/etudiants/fiche-inscription', $fiche_inscription_name);
            }
            if (!is_null($request->fiche_oriantation)) {
                $fiche_oriantation_name = str_replace(' ', '_', $request->nom_prenom_etudiant). '_' . time() . 'fiche_oriantation.' . $request->fiche_oriantation->extension();
                $fiche_oriantation_path = $request->fiche_inscription->storeAs('public/etudiants/fiche-orientation', $fiche_oriantation_name);
            }
            if (!is_null($request->extrait_naissance)) {
                $extrait_name = str_replace(' ', '_', $request->nom_prenom_etudiant). '_' . time() . '_extrait_naissance.' . $request->extrait_naissance->extension();
                $extrait_path = $request->extrait_naissance->storeAs('public/etudiants/extrait-naissance', $extrait_name);
            }
            if (!is_null($request->bac_legalise)) {
                $bac_legalise_name = str_replace(' ', '_', $request->nom_prenom_etudiant). '_' . time() . '_bac_legalise.' . $request->bac_legalise->extension();
                $bac_legalise_path = $request->bac_legalise->storeAs('public/etudiants/bac', $bac_legalise_name);
            }
            if (!is_null($request->cp_note_bac)) {
                $cp_note_bac_name = str_replace(' ', '_', $request->nom_prenom_etudiant). '_' . time() . '_cp_note_bac.' . $request->cp_note_bac->extension();
                $cp_note_bac_path = $request->cp_note_bac->storeAs('public/etudiants/note-bac', $cp_note_bac_name);
            }
            if (!is_null($request->photo)) {
                $photo_name = str_replace(' ', '_', $request->nom_prenom_etudiant). '_' . time() . '_photo.' . $request->photo->extension();
                $photo_path = $request->photo->storeAs('public/etudiants/photo', $photo_name);
            }
        } 
        else {
            if (!is_null($request->fiche_inscription)) {
                $fiche_inscription_name = str_replace(' ', '_', $request->nom_prenom_etudiant). '_' . time() . '_fiche_inscription.' . $request->fiche_inscription->extension();
                Storage::delete($inscription->fiche_inscription);
                $fiche_inscription_path = $request->fiche_inscription->storeAs('public/etudiants/fiche-inscription', $fiche_inscription_name);
            }
            if (!is_null($request->fiche_oriantation)) {
                $fiche_oriantation_name = str_replace(' ', '_', $request->nom_prenom_etudiant). '_' . time() . 'fiche_oriantation.' . $request->fiche_oriantation->extension();
                Storage::delete($inscription->fiche_oriantation);
                $fiche_oriantation_path = $request->fiche_inscription->storeAs('public/etudiants/fiche-orientation', $fiche_oriantation_name);
            }
            if (!is_null($request->extrait_naissance)) {
                $extrait_name = str_replace(' ', '_', $request->nom_prenom_etudiant). '_' . time() . '_extrait_naissance.' . $request->extrait_naissance->extension();
                Storage::delete($inscription->extrait_naissance);
                $extrait_path = $request->extrait_naissance->storeAs('public/etudiants/extrait-naissance', $extrait_name);
            }
            if (!is_null($request->bac_legalise)) {
                $bac_legalise_name = str_replace(' ', '_', $request->nom_prenom_etudiant). '_' . time() . '_bac_legalise.' . $request->bac_legalise->extension();
                Storage::delete($inscription->bac_legalise);
                $bac_legalise_path = $request->bac_legalise->storeAs('public/etudiants/bac', $bac_legalise_name);
            }
            if (!is_null($request->cp_note_bac)) {
                $cp_note_bac_name = str_replace(' ', '_', $request->nom_prenom_etudiant). '_' . time() . '_cp_note_bac.' . $request->cp_note_bac->extension();
                Storage::delete($inscription->cp_note_bac);
                $cp_note_bac_path = $request->cp_note_bac->storeAs('public/etudiants/note-bac', $cp_note_bac_name);
            }
            if (!is_null($request->photo)) {
                $photo_name = str_replace(' ', '_', $request->nom_prenom_etudiant). '_' . time() . '_photo.' . $request->photo->extension();
                Storage::delete($inscription->photo);
                $photo_path = $request->photo->storeAs('public/etudiants/photo', $photo_name);
            }
        }

        Auth::user()->update([
            'fullname' => $request->nom_complet,
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'numero_etudiant' => $request->numero,
            'email' => $request->email,
            'sexe' => $request->sexe,
            // 'statut' => $request->statut,
            // 'password' => "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi",
            'nationalite' => $request->nationalite,
            // 'matricule_etudiant' => $request->matricule,
            'domicile' => $request->domicile,
            'etablissement_origine' => $request->etablissement_origine,
            'adresse_geographique' => $request->adresse_geographique,
            'niveau_etude' => $request->niveau_etude,
            'autre_diplome' => $request->autre_diplome,
            'serie_bac' => $request->serie_bac,
            'premier_entree_ua' => $request->date_premiere_entree,
            'responsable_legal' => $request->responsable_legal,
            'responsable_legal_precision' => $request->responsable_legal_precision,
            'responsable_legal_fullname' => $request->responsable_legal_fullname,
            'responsable_legal_profession' => $request->responsable_legal_profession,
            'responsable_legal_adresse' => $request->responsable_legal_adresse,
            'responsable_legal_domicile' => $request->responsable_legal_domicile,
            'responsable_legal_numero' => $request->responsable_legal_numero,
            // 'classe_id' => $request->classe,
        ]);

        $inscription->update([
            'fiche_inscription' => $fiche_inscription_path ?? null,
            'fiche_oriantation' => $fiche_oriantation_path ?? null,
            'extrait_naissance' => $extrait_path ?? null,
            'bac_legalise' => $bac_legalise_path ?? null,
            'cp_note_bac' => $cp_note_bac_path ?? null,
            'photo' => $photo_path ?? null,
        ]);

        flashy()->message('Informations enregistrées avec succès');
        return redirect()->route('user.fiche-inscription');
    }

    public function ficheInscription() {
        $etudiant = Auth::user();
        $anneeAcademique = $this->anneeAcademique;
        return view('etudiant.inscription.inscription-fiche', compact('etudiant', 'anneeAcademique'));
    }

    public function ModifFicheInscription() {
        return view('etudiant.inscription.inscription-modif-form');
    }

    // public function resultatTest() {
    //     return view('etudiant.resultat-test');
    // }

    // public function inscriptionOld() {
    //     $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
    //     $inscription = Inscription::where('annee_academique_id', $anneeAcademique->id)->where('user_id', Auth::id())->first();

    //     return $inscription == NULL ? view('etudiant.inscription.create') : view('etudiant.inscription.edit', compact('inscription'));
    // }

    // public function storeInscriptionOld(Request $request) {
    //     $this->validate($request, [
    //         'date_inscription' => 'required|date',
    //         'nationalite' => 'required|string',
    //         'nom_prenom_pere' => 'required|string',
    //         'profession_pere' => 'nullable|string',
    //         'lieu_service_pere' => 'nullable|string',
    //         'boite_postale_pere' => 'nullable|string',
    //         'tel_service_pere' => 'nullable|integer',
    //         'cel_pere' => 'nullable|integer',
    //         'email_pere' => 'nullable|email',
    //         'lieu_habitation_pere' => 'nullable|string',
    //         'numero_appartement_pere' => 'nullable|string',
    //         'tel_pere' => 'nullable|integer',
    //         'nom_prenom_mere' => 'required|string',
    //         'profession_mere' => 'nullable|string',
    //         'lieu_service_mere' => 'nullable|string',
    //         'boite_postale_mere' => 'nullable|string',
    //         'tel_service_mere' => 'nullable|integer',
    //         'cel_mere' => 'nullable|integer',
    //         'email_mere' => 'nullable|email',
    //         'lieu_habitation_mere' => 'nullable|string',
    //         'numero_appartement_mere' => 'nullable|string',
    //         'tel_mere' => 'nullable|integer',
    //         'adresse_pays_origine' => 'nullable|string',
    //         'tel_origine' => 'nullable|integer',
    //         'cel_origine' => 'nullable|integer',
    //         'ecole_1' => 'required|string',
    //         'annee_1' => 'required|digits:4',
    //         'formation_1' => 'required|string',
    //         'ecole_2' => 'required|string',
    //         'annee_2' => 'required|digits:4|after:annee_1',
    //         'formation_2' => 'required|string',
    //         'ecole_3' => 'required|string',
    //         'annee_3' => 'required|digits:4|after:annee_2',
    //         'formation_3' => 'required|string',
    //         'maladie' => 'nullable|string',
    //         'precision_maladie' => 'nullable|string',
    //         'nom_medecin' => 'nullable|string',
    //         'tel_medecin' => 'nullable|integer',
    //         'nom_cas_urgent' => 'nullable|string',
    //         'tel_cas_urgent' => 'nullable|integer',
    //         'extrait_naissance' => 'nullable|mimes:pdf|max:2048',
    //         'bac_legalise' => 'nullable|mimes:pdf|max:2048',
    //         'photocopie_bulletin' => 'nullable|mimes:pdf',
    //         'photocopie_bts' => 'nullable|mimes:pdf|max:2048',
    //         'autre_diplome' => 'nullable|mimes:pdf',
    //         'soumettre' => 'required|integer',
    //     ]);

    //     $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
    //     $inscription = Inscription::where('annee_academique_id', $anneeAcademique->id)->where('user_id', Auth::id())->first();

    //     if (is_null($inscription)) {
    //         if (!is_null($request->extrait_naissance)) {
    //             $extrait_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_extrait_naissance.' . $request->extrait_naissance->extension();
    //             $extrait_path = $request->extrait_naissance->storeAs('public/etudiants/extrait-naissance', $extrait_name);
    //         }
            
    //         if (!is_null($request->bac_legalise)) {
    //             $bac_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_bac.' . $request->bac_legalise->extension();
    //             $bac_path = $request->bac_legalise->storeAs('public/etudiants/bac', $bac_name);
    //         }
    
    //         if (!is_null($request->photocopie_bulletin)) {
    //             $bulletin_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_bulletin.' . $request->photocopie_bulletin->extension();
    //             $bulletin_path = $request->photocopie_bulletin->storeAs('public/etudiants/bulletin', $bulletin_name);
    //         }
    
    //         if (!is_null($request->photocopie_bts)) {
    //             $bts_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_bts.' . $request->photocopie_bts->extension();
    //             $bts_path = $request->photocopie_bts->storeAs('public/etudiants/bts', $bts_name);
    //         }
    
    //         if (!is_null($request->autre_diplome)) {
    //             $autre_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_autre.' . $request->autre_diplome->extension();
    //             $autre_path = $request->autre_diplome->storeAs('public/etudiants/autre', $autre_name);
    //         }

    //         if($request->soumettre == 1) {
    //             Inscription::create([
    //                 'date_inscription' => $request->date_inscription,
    //                 'ecole_1' => $request->ecole_1,
    //                 'annee_1' => $request->annee_1,
    //                 'formation_1' => $request->formation_1,
    //                 'ecole_2' => $request->ecole_2,
    //                 'annee_2' => $request->annee_2,
    //                 'formation_2' => $request->formation_2,
    //                 'ecole_3' => $request->ecole_3,
    //                 'annee_3' => $request->annee_3,
    //                 'formation_3' => $request->formation_3,
    //                 'extrait_naissance' => $extrait_path ?? NULL,
    //                 'copie_legalise_bac' => $bac_path ?? NULL,
    //                 'copie_bulletin_bac_bts' => $bulletin_path ?? NULL,
    //                 'copie_diplome_bac_plus' => $bts_path ?? NULL,
    //                 'copie_diplome_autre' => $autre_path ?? NULL,
    //                 'soumettre' => 1,
    //                 'user_id' => Auth::id(),
    //                 'annee_academique_id' => $anneeAcademique->id,
    //             ]);
    //         }
    //         else {
    //             Inscription::create([
    //                 'date_inscription' => $request->date_inscription,
    //                 'ecole_1' => $request->ecole_1,
    //                 'annee_1' => $request->annee_1,
    //                 'formation_1' => $request->formation_1,
    //                 'ecole_2' => $request->ecole_2,
    //                 'annee_2' => $request->annee_2,
    //                 'formation_2' => $request->formation_2,
    //                 'ecole_3' => $request->ecole_3,
    //                 'annee_3' => $request->annee_3,
    //                 'formation_3' => $request->formation_3,
    //                 'extrait_naissance' => $extrait_path ?? NULL,
    //                 'copie_legalise_bac' => $bac_path ?? NULL,
    //                 'copie_bulletin_bac_bts' => $bulletin_path ?? NULL,
    //                 'copie_diplome_bac_plus' => $bts_path ?? NULL,
    //                 'copie_diplome_autre' => $autre_path ?? NULL,
    //                 'user_id' => Auth::id(),
    //                 'annee_academique_id' => $anneeAcademique->id,
    //             ]);
    //         }
    //     }
    //     else {
    //         if (!is_null($request->extrait_naissance)) {
    //             $extrait_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_extrait_naissance.' . $request->extrait_naissance->extension();
    //             Storage::delete($inscription->extrait_naissance);
    //             $extrait_path = $request->extrait_naissance->storeAs('public/etudiants/extrait-naissance', $extrait_name);
    //         }
            
    //         if (!is_null($request->bac_legalise)) {
    //             $bac_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_bac.' . $request->bac_legalise->extension();
    //             Storage::delete($inscription->copie_legalise_bac);
    //             $bac_path = $request->bac_legalise->storeAs('public/etudiants/bac', $bac_name);
    //         }
    
    //         if (!is_null($request->photocopie_bulletin)) {
    //             $bulletin_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_bulletin.' . $request->photocopie_bulletin->extension();
    //             Storage::delete($inscription->copie_bulletin_bac_bts);
    //             $bulletin_path = $request->photocopie_bulletin->storeAs('public/etudiants/bulletin', $bulletin_name);
    //         }
    
    //         if (!is_null($request->photocopie_bts)) {
    //             $bts_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_bts.' . $request->photocopie_bts->extension();
    //             Storage::delete($inscription->copie_diplome_bac_plus);
    //             $bts_path = $request->photocopie_bts->storeAs('public/etudiants/bts', $bts_name);
    //         }
    
    //         if (!is_null($request->autre_diplome)) {
    //             $autre_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_autre.' . $request->autre_diplome->extension();
    //             Storage::delete($inscription->copie_diplome_autre);
    //             $autre_path = $request->autre_diplome->storeAs('public/etudiants/autre', $autre_name);
    //         }
            
    //         if($request->soumettre == 0) {
    //             $inscription->update([
    //                 'date_inscription' => $request->date_inscription,
    //                 'ecole_1' => $request->ecole_1,
    //                 'annee_1' => $request->annee_1,
    //                 'formation_1' => $request->formation_1,
    //                 'ecole_2' => $request->ecole_2,
    //                 'annee_2' => $request->annee_2,
    //                 'formation_2' => $request->formation_2,
    //                 'ecole_3' => $request->ecole_3,
    //                 'annee_3' => $request->annee_3,
    //                 'formation_3' => $request->formation_3,
    //                 'extrait_naissance' => $extrait_path ?? $inscription->extrait_naissance,
    //                 'copie_legalise_bac' => $bac_path ?? $inscription->copie_legalise_bac,
    //                 'copie_bulletin_bac_bts' => $bulletin_path ?? $inscription->copie_bulletin_bac_bts,
    //                 'copie_diplome_bac_plus' => $bts_path ?? $inscription->copie_diplome_bac_plus,
    //                 'copie_diplome_autre' => $autre_path ?? $inscription->copie_diplome_autre,
    //                 'user_id' => Auth::id(),
    //                 'annee_academique_id' => $anneeAcademique->id,
    //             ]);
    //         }
    //         else {
    //             $inscription->update([
    //                 'date_inscription' => $request->date_inscription,
    //                 'ecole_1' => $request->ecole_1,
    //                 'annee_1' => $request->annee_1,
    //                 'formation_1' => $request->formation_1,
    //                 'ecole_2' => $request->ecole_2,
    //                 'annee_2' => $request->annee_2,
    //                 'formation_2' => $request->formation_2,
    //                 'ecole_3' => $request->ecole_3,
    //                 'annee_3' => $request->annee_3,
    //                 'formation_3' => $request->formation_3,
    //                 'extrait_naissance' => $extrait_path ?? $inscription->extrait_naissance,
    //                 'copie_legalise_bac' => $bac_path ?? $inscription->copie_legalise_bac,
    //                 'copie_bulletin_bac_bts' => $bulletin_path ?? $inscription->copie_bulletin_bac_bts,
    //                 'copie_diplome_bac_plus' => $bts_path ?? $inscription->copie_diplome_bac_plus,
    //                 'copie_diplome_autre' => $autre_path ?? $inscription->copie_diplome_autre,
    //                 'soumettre' => 1,
    //                 'user_id' => Auth::id(),
    //                 'annee_academique_id' => $anneeAcademique->id,
    //             ]);
    //         }
    //     }

    //     Auth::user()->update([
    //         'nationnalite' => $request->nationalite,
    //         'fullname_pere' => $request->nom_prenom_pere,
    //         'profession_pere' => $request->profession_pere,
    //         'lieu_service_pere' => $request->lieu_service_pere,
    //         'telephone_service_pere' => $request->tel_service_pere,
    //         'numero_pere' => $request->cel_pere,
    //         'email_pere' => $request->email_pere,
    //         'boite_postale_pere' => $request->boite_postale_pere,
    //         'lieu_habitation_pere' => $request->lieu_habitation_pere,
    //         'numero_appartement_pere' => $request->numero_appartement_pere,
    //         'numero_habitation_pere' => $request->tel_pere,

    //         'fullname_mere' => $request->nom_prenom_mere,
    //         'profession_mere' => $request->profession_mere,
    //         'lieu_service_mere' => $request->lieu_service_mere,
    //         'telephone_service_mere' => $request->tel_service_mere,
    //         'numero_mere' => $request->cel_mere,
    //         'email_mere' => $request->email_mere,
    //         'boite_postale_mere' => $request->boite_postale_mere,
    //         'lieu_habitation_mere' => $request->lieu_habitation_mere,
    //         'numero_appartement_mere' => $request->numero_appartement_mere,
    //         'numero_habitation_mere' => $request->tel_mere,

    //         'bp_pays_origine' => $request->adresse_pays_origine,
    //         'numero_etranger' => $request->tel_origine,
    //         'cellulaire_etranger' => $request->cel_origine,
    //         'crises_maladie' => $request->maladie == 'non' ? 0 : 1,
    //         'maladie' => $request->precision_maladie,
    //         'fullname_medecin' => $request->nom_medecin,
    //         'numero_medecin' => $request->tel_medecin,
    //         'fullname_contact_urgence' => $request->nom_cas_urgent,
    //         'numero_contact_urgence' => $request->tel_cas_urgent,
    //     ]);

    //     $success = $request->soumettre;
    //     return redirect()->back()->with('success', $success);
    // }

    public function recepice() {
        $pdf = new Fpdi();

        // Add a page
        $pdf->AddPage();

        //Setting font
        $pdf->SetFont('helvetica', '', 14);

        // Set source file
        $pdfPath = storage_path('app/templates/inscrition etudiant 1.pdf');
        $pdf->setSourceFile($pdfPath);

        $tplId = $pdf->importPage(1);

        // use the imported page and place it at point 10,10 with a width of 100 mm
        // $pdf->useImportedPage($tplId, 0, 0, 198);

        $pdf->useTemplate($tplId, null, null, null, 300, null);

        $pdf->SetXY(40, 120);
        $pdf->Write(0, 'Mon nom');

        $pdf->SetXY(50, 129);
        $pdf->Write(0, 'Mon prenom');

        $pdf->SetXY(70, 138);
        $pdf->Write(0, Auth::user()->date_naissance);

        $pdf->SetXY(70, 146);
        $pdf->Write(0, Auth::user()->lieu_naissance);

        $pdf->SetXY(61, 155);
        $pdf->Write(0, Auth::user()->postale);

        $pdf->SetXY(64, 163);
        $pdf->Write(0, Auth::user()->numero);

        $pdf->SetXY(160, 164);
        $pdf->Write(0, Auth::user()->parent);

        // Output results  I: Direct input ,D: Download the file ,F: Save to local file ,S: Return string 
        $pdf->Output('I', 'recepice');
    }

    public function profile() {
        return view('etudiant.profile');
    }

    public function listeMatiere() {
        $data = new OtherDataService;
        $dataNotesSem1 = $data->noteEtudiant(Auth::id(), 1);
        $dataNotesSem2 = $data->noteEtudiant(Auth::id(), 2);
        return view('etudiant.liste-matieres', compact('dataNotesSem1', 'dataNotesSem2'));
    }

    // public function notes($id) {
    //     $matiere = Matiere::findOrFail($id);
    //     $note = Note::where('matiere_id', $matiere->id)->where('user_id', Auth::id())->first();
    //     return view('etudiant.note', compact('note'));
    // }

    public function scolarite() {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $scolarites = [];

        foreach (Auth::user()->scolarites->where('annee_academique_id', $anneeAcademique->id)->sortBy('created_at') as $scolarite) {
            array_push($scolarites, [
                'scolarite' => $scolarite->scolarite,
                'montant' => $scolarite->payee,
                'reste' => $scolarite->reste,
                'numero_operation' => $scolarite->numero_operation,
                'created_at' => $scolarite->created_at,
            ]);
        }

        return view('etudiant.scolarite.scolarite', compact('scolarites'));
    }

    public function scolaritePDF() {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $scolarites = [];

        foreach (Auth::user()->scolarites->where('annee_academique_id', $anneeAcademique->id)->sortBy('created_at') as $scolarite) {
            array_push($scolarites, [
                'scolarite' => $scolarite->scolarite,
                'montant' => $scolarite->payee,
                'reste' => $scolarite->reste,
                'numero_operation' => $scolarite->numero_operation,
                'created_at' => $scolarite->created_at,
            ]);
        }

        $scolarite = PDF::loadView('etudiant.scolarite.scolarite-pdf', compact('scolarites'));
        return $scolarite->stream();
        // return view('etudiant.scolarite.scolarite-pdf', compact('scolarites'));
    }

    public function schedule(ScheduleService $scheduleService) {
        $etudiant = User::findOrFail(Auth::id());
        $anneeAcademique = $this->anneeAcademique;
        $jours = Cours::JOURS;
        $donneesCalendrier = $scheduleService->genererDonneesCalendrier($jours, $etudiant->classe($this->anneeAcademique->id)->id);

        return view('etudiant.maquette', compact('jours', 'donneesCalendrier', 'anneeAcademique'));
    }

    public function ressourcesIndex() {
        $etudiant = User::findOrFail(Auth::id());
        $matieres = $etudiant->classe($this->anneeAcademique->id)->niveauFaculte->matieres;
        return view('etudiant.resources.index', compact('matieres'));
    }

    public function ressourceShow($id) {
        $matiere = Matiere::findOrFail($id);
        $etudiant = User::findOrFail(Auth::id());
        $ressources = ResourcesCours::where('classe_id', $etudiant->classe($this->anneeAcademique->id))->where('matiere_id', $matiere->id)->get();
        return view('etudiant.resources.show', compact('matiere', 'ressources'));
    }

    public function changePassword(Request $request) {
        $this->validate($request, [
            'numero' => 'required|digits:10|unique:users,numero_etudiant,'. Auth::id(),
            'ancien_password' => 'required',
            'nouveau_password' => 'required|confirmed',
        ]);

        #Match The Old Password
        if(!Hash::check($request->ancien_password, auth()->user()->password)){
            return back()->with("error", "L'ancien mot de passe ne correspond pas !");
        }

        #Update the new Password
        Auth::user()->update([
            'numero_etudiant' => $request->numero,
            'password' => Hash::make($request->nouveau_password)
        ]);

        flashy()->message('Mot de passe modifié');
        return back()->with("status", "Le mot de passe a été modifié avec succès!");    
    }

    public function chat() {
        $master = 'etudiant';
        return view('informatique.chat.chat', compact('master'));
    }
}

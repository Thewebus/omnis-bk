<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Note;
use App\Models\Test;
use App\Models\User;
use App\Models\Classe;
use App\Models\Faculte;
use App\Models\Matiere;
use App\Models\Institut;
use App\Models\Scolarite;
use App\Models\Professeur;
use App\Models\CahierTexte;
use App\Models\Inscription;
use Illuminate\Http\Request;
use App\Models\AnneeAcademique;
use Illuminate\Validation\Rule;
use App\Models\ClasseProfesseur;
use App\Models\MatiereProfesseur;
use App\Services\BulletinService;
use App\Services\OtherDataService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\StoreEtudiantRequest;

class PersonnelDefaultController extends Controller
{    
    public function personnelDash() {
        // Récupération des étudiants dont l'inscription est validé
        // pour la dernière année académique
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $nbrEtudiants = User::whereHas('inscriptions', function(Builder $query) use ($anneeAcademique) {
            $query->where('valide', 1)->where('annee_academique_id', $anneeAcademique->id);
        })->count();

        $nbrProfs = Professeur::all()->count();
        $nbrFilieres = Faculte::all()->count();
        $nbrInstituts = Institut::all()->count();
        $nbrClasses = Classe::all()->count();

        return view('personnels.dashboard', compact('nbrEtudiants', 'nbrProfs', 'nbrFilieres', 'nbrClasses', 'nbrInstituts'));
    }

    public function profil() {
        return view('personnels.profil.profil');
    }

    public function changeInformationsPost(Request $request) {
        $this->validate($request, [
            'nom_prenoms' => 'required|string',
            'numero' => 'required|digits:10|unique:personnels,numero,' . Auth::id(),
        ]);

        Auth::user()->update([
            'fullname' => $request->nom_prenoms,
            'numero' => $request->numero,
        ]);

        flashy()->message('Information enrégistrées !');
        return redirect()->back();
    }

    public function changePassword(Request $request) {
        $this->validate($request, [
            'email' => 'required|email|unique:personnels,email,'. Auth::id(),
            'ancien_password' => 'required',
            'nouveau_password' => 'required|confirmed',
        ]);

        #Match The Old Password
        if(!Hash::check($request->ancien_password, auth()->user()->password)){
            return back()->with("error", "L'ancien mot de passe ne correspond pas !");
        }

        #Update the new Password
        Auth::user()->update([
            'password' => Hash::make($request->nouveau_password)
        ]);

        flashy()->message('Mot de passe modifié');
        return back()->with("status", "Le mot de passe a été modifié avec succès!");    
    }

    public function listEtudiants() {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $tests = Test::with('etudiant')->where('annee_academique_id', $anneeAcademique->id)->whereNull('status')->get();
        return view('personnels.liste-etudiants', compact('tests'));
    }

    public function nouvellesNotes($id) {
        $etudiant = User::FindOrFail($id);
        return view('personnels.nouvelles-notes', compact('etudiant'));
    }

    public function insertionNotes(Request $request, $id) {
        $this->validate($request, [
            'fr' => 'required|numeric',
            'ang' => 'required|numeric',
            'math' => 'required|numeric',
        ]);

        $test = Test::findOrFail($id);
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $moyenne = ($request->fr + $request->ang + $request->math) / 3; 

        $test->update([
            'note_fr' => $request->fr,
            'note_ang' => $request->ang,
            'note_math' => $request->math,
            'moyenne' => $moyenne,
            'status' => ($moyenne > 10) ? 'admis' : 'refusé',
            'annee_academique_id' => $anneeAcademique->id,
        ]);

        // $test->etudiant->notify(new ResultatTest($test));

        $success = true;
        return redirect()->back()->withSuccess('success');
    }

    public function resultats() {
        $etudiants = User::whereNotNull('numero')->orderBy('fullname', 'ASC')->get();
        return view('personnels.resultats', compact('etudiants'));
    }

    public function professeurListe() {
        $professeurs = Professeur::where('valide', 1)->orderBy('fullname')->get();
        return view('personnels.professeur-liste', compact('professeurs'));
    }

    public function professeurDetails($id) {
        $professeur = Professeur::findOrFail($id);
        return view('personnels.professeur-details', compact('professeur'));
    }

    public function cahierTexteClasse() {
        $classes = Classe::orderBy('nom', 'ASC')->get();
        return view('personnels.cahier-texte.classe', compact('classes'));
    }

    public function cahierTexte($id) {
        $classe = Classe::findOrFail($id);
        $cahierTextes = CahierTexte::where('classe_id', $classe->id)->orderBy('created_at', 'DESC')->get();
        return view('personnels.cahier-texte.cahier-text', compact('classe', 'cahierTextes'));
    }

    public function listeClasseProgression() {
        $classes = Classe::orderBy('nom', 'ASC')->get();
        Auth::user()->type == 'informaticien' ? $master = 'informatique' : $master = 'personnel';

        return view('personnels.progression.liste-classe', compact('classes', 'master'));
    }

    public function coursClasseProgression($id) {
        $classe = Classe::findOrFail($id);
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $progressions = [];

        // Récupération des matières enseignées pour la classe courante avec la dernière année académique
        $matiereProfesseurs = MatiereProfesseur::where('classe_id', $classe->id)->where('annee_academique_id', $anneeAcademique->id)->get();
        foreach ($matiereProfesseurs as $matiereProfesseur) {
            $pourcentage = ($matiereProfesseur->progression * 100) / $matiereProfesseur->volume_horaire;
            $professeur = Professeur::findOrFail($matiereProfesseur->professeur_id);
            $matiere = Matiere::findOrFail($matiereProfesseur->matiere_id);
            array_push($progressions, [
                'pourcentage' => $pourcentage,
                'progression' => $matiereProfesseur->progression,
                'nom_classe' => $classe->nom,
                'nom_prof' => $professeur->fullname,
                'nom_matiere' => $matiere->nom,
                'volume_horaire' => $matiereProfesseur->volume_horaire,
            ]);
        }
        
        Auth::user()->type == 'informaticien' ? $master = 'informatique' : $master = 'personnel';

        return view('personnels.progression.progression', compact('progressions', 'master'));
    }

    public function inscriptionEtudiant() {
        $classes = Classe::orderBy('nom', 'ASC')->get();
        $facultes = Faculte::orderBy('nom', 'ASC')->get();
        return view('personnels.inscription.inscription-form', compact('classes', 'facultes'));
    }

    public function inscriptionEtudiantPost(StoreEtudiantRequest $request) {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $etudiant = User::create([
            'fullname' => $request->nom_complet,
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'numero_etudiant' => $request->numero,
            'email' => $request->email,
            'sexe' => $request->sexe,
            'statut' => $request->statut,
            'password' => "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi",
            'nationalite' => $request->nationalite,
            'matricule_etudiant' => $request->matricule,
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
            'classe_id' => $request->classe,
        ]);

        $etudiant->update(['identifiant_bulletin' => $etudiant->id + 10000]);

        if ($request->statut == 'affecté') {
            $scolarite = $etudiant->classe->niveauFaculte->scolarite_affecte;
        } else if ($request->statut == 'non affecté') {
            $scolarite = $etudiant->classe->niveauFaculte->scolarite_nonaffecte;
        }
        else {
            $scolarite = $etudiant->classe->niveauFaculte->scolarite_reaffecte;    
        }

        // Enregistrement des fichiers chargés.
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

        Inscription::create([
            'frais_inscription' => $scolarite,
            'net_payer' => $scolarite,
            'fiche_inscription' =>  $fiche_inscription_path ?? null,
            'fiche_oriantation' =>  $fiche_oriantation_path ?? null,
            'extrait_naissance' =>  $extrait_path ?? null,
            'bac_legalise' =>  $bac_legalise_path ?? null,
            'cp_note_bac' =>  $cp_note_bac_path ?? null,
            'photo' =>  $photo_path ?? null,
            'user_id' => $etudiant->id,
            'valide' => 1,
            'annee_academique_id' => $anneeAcademique->id,
        ]);

        flashy()->message('Etudiant enrégistré !');
        return redirect()->back();
    }

    public function inscriptionValideeListeEtudiant() {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $etudiants = User::whereHas('inscriptions', function(Builder $query) use ($anneeAcademique) {
            $query->where('valide', 1)->where('annee_academique_id', $anneeAcademique->id);
        })->get();
        return view('personnels.inscription.liste-etudiants', compact('etudiants'));
    }

    public function inscriptionDetails($id) {
        $inscription = Inscription::with('etudiant')->findOrFail($id);
        return view('personnels.inscription.inscription-fiche', compact('inscription'));
    }

    public function modifInscriptionForm($id) {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $etudiant = User::findOrFail($id);
        $inscription = Inscription::where('annee_academique_id', $anneeAcademique->id)->where('user_id', $etudiant->id)->first();
        $classes = Classe::orderBy('nom', 'ASC')->get();
        $facultes = Faculte::orderBy('nom', 'ASC')->get();
        return view('personnels.inscription.inscription-modif-form', compact('etudiant', 'inscription', 'facultes', 'classes'));
    }

    public function modifInscriptionFormPost(Request $request, $id) {
        $etudiant = User::findOrFail($id);
        $this->validate($request, [
            'nom_complet' => 'required|string',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string',
            'nationalite' => 'required|string',
            'sexe' => 'required|in:masculin,feminin',
            'domicile' => 'required|string',
            'numero' => ['required', 'digits:10', Rule::unique('users', 'numero_etudiant')->ignore($etudiant->id)],
            'email' => ['nullable', Rule::unique('users', 'email')->ignore($etudiant->id)],
            'etablissement_origine' => 'required|string',
            'adresse_geographique' => 'required|string',
            'niveau_etude' => 'nullable|string',
            'autre_diplome' => 'nullable|string',
            'serie_bac' => 'required|string',
            'statut' => 'required|in:affecté,non affecté,réaffecté',
            'niveau_etude_2' => 'required|string',
            'faculte' => 'required|integer',
            'date_premiere_entree' => ['required', 'digits:4'],
            'classe' => ['required', 'integer'],
            'matricule' => ['required', 'string'],
            'responsable_legal' => 'required|string',
            'responsable_legal_precision' => 'nullable|string',
            'responsable_legal_fullname' => 'required|string',
            'responsable_legal_profession' => 'required|string',
            'responsable_legal_adresse' => 'nullable|string',
            'responsable_legal_domicile' => 'required|string',
            'responsable_legal_numero' => 'required|string',
            
            // 'responsable_scolarite_fullname' => 'required|string',
            // 'responsable_scolarite_profession' => 'required|string',
            // 'responsable_scolarite_numero' => 'required|string',
            // 'responsable_scolarite_adresse' => 'required|string',
            // 'responsable_scolarite_domicile' => 'required|string',

            'fiche_inscription' => 'nullable|mimes:pdf|max:5120',
            'fiche_oriantation' => 'nullable|mimes:pdf|max:5120',
            'extrait_naissance' => 'nullable|mimes:pdf|max:5120',
            'bac_legalise' => 'nullable|mimes:pdf|max:5120',
            'cp_note_bac' => 'nullable|mimes:pdf|max:5120',
            'photo' => 'nullable|mimes:png,jpg,jpeg|max:5120',
        ]);
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $inscription = Inscription::where('annee_academique_id', $anneeAcademique->id)->where('user_id', $etudiant->id)->first();

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
        
        $etudiant->update([
            'fullname' => $request->nom_complet,
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'numero_etudiant' => $request->numero,
            'email' => $request->email,
            'sexe' => $request->sexe,
            'statut' => $request->statut,
            // 'password' => "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi",
            'nationalite' => $request->nationalite,
            'matricule_etudiant' => $request->matricule,
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
            'classe_id' => $request->classe,
        ]);
        if ($request->statut == 'affecté') {
            $scolarite = $etudiant->classe->niveauFaculte->scolarite_affecte;
        } else if ($request->statut == 'non affecté') {
            $scolarite = $etudiant->classe->niveauFaculte->scolarite_nonaffecte;
        }
        else {
            $scolarite = $etudiant->classe->niveauFaculte->scolarite_reaffecte;    
        }

        $inscription->update([
            'frais_inscription' => $scolarite,
            'net_payer' => $scolarite,
            'fiche_inscription' => $fiche_inscription_path ?? null,
            'fiche_oriantation' => $fiche_oriantation_path ?? null,
            'extrait_naissance' => $extrait_path ?? null,
            'bac_legalise' => $bac_legalise_path ?? null,
            'cp_note_bac' => $cp_note_bac_path ?? null,
            'photo' => $photo_path ?? null,
        ]);

        flashy()->message('Informations enregistrées avec succès');
        return redirect()->route('admin.scolarite-inscritpion-detail', $inscription->id);
    }

    public function listeClassesNotes() {
        $classes = Classe::orderBy('nom', 'DESC')->get();
        return view('personnels.note.liste-classe-note', compact('classes'));
    }

    public function listeMatiereNote($id) {
        $classe = Classe::findOrFail($id);
        $matieres = Matiere::where('classe_id', $classe->id)->orderBy('semestre', 'ASC')->orderBy('nom', 'ASC')->get();
        return view('personnels.note.liste-matieres-notes', compact('classe', 'matieres'));
    }

    public function notesMatiere($id) {
        $data = new OtherDataService;
        $dataBrute = $data->notesMatiere($id);
        $classe = $dataBrute[0];
        $matiere = $dataBrute[1];
        $dataNotes = $dataBrute[2];
        return view('personnels.note.note', compact('classe', 'matiere', 'dataNotes'));
    }

    public function addNote($id) {
        $dataBrute = (new OtherDataService)->notesMatiere($id);
        $classe = $dataBrute[0];
        $matiere = $dataBrute[1];
        $dataNotes = $dataBrute[2];
        return view('personnels.note.note-add', compact('classe', 'matiere', 'dataNotes'));
    }

    public function postNote(Request $request, $id) {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $matiere = Matiere::findOrFail($id);
        $matiereProfesseur = MatiereProfesseur::with('professeur')->where('annee_academique_id', $anneeAcademique->id)
            ->where('matiere_id', $matiere->id)
            ->where('classe_id', $matiere->classe->id)
            ->first();
        
        $professeur = $matiereProfesseur->professeur;
        foreach ($request->except('_token') as $etudiantId => $noteCourantes) {
            $etudiant = User::findOrFail($etudiantId);
            $notes = Note::where('annee_academique_id', $anneeAcademique->id)
                ->where('classe_id', $matiere->classe->id)
                ->where('matiere_id', $matiere->id)
                ->where('user_id', $etudiant->id)->first();

            if(!is_null($notes)) {
                $notes->systeme_calcul == 'normal' ? $moyenne = (($notes->note_1 + $notes->note_2 + $notes->note_3 + $notes->partiel_session_1) / 4) : $moyenne = (0.4 * (($notes->note_1 +$notes->note_2 + $notes->note_3) / 3)) + ($notes->partiel_session_1 * 0.6);
                $notes->update([
                    'note_1' => $noteCourantes[0],
                    'note_2' => $noteCourantes[1],
                    'note_3' => $noteCourantes[2],
                    'moyenne' => $moyenne,
                    'status' => $moyenne >= 10 ? 'admis' : 'ajourné',
                    'professeur_id' => $professeur->id,
                ]);
            }
            else {
                Note::create([
                    'note_1' => $noteCourantes[0],
                    'note_2' => $noteCourantes[1],
                    'note_3' => $noteCourantes[2],
                    'classe_id' => $matiere->classe->id,
                    'matiere_id' => $matiere->id,
                    'user_id' => $etudiant->id,
                    'professeur_id' => $professeur->id,
                    'annee_academique_id' => $anneeAcademique->id
                ]);
            }
        }

        flashy('Notes insérées !');
        return redirect()->route('admin.scolarite-notes-matiere', $matiere->id);
    }

    public function suppressionNotes($id) {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $matiere = Matiere::findOrFail($id);

        foreach($matiere->classe->etudiants as $etudiant) {
            $notes = Note::where('annee_academique_id', $anneeAcademique->id)
                ->where('classe_id', $matiere->classe->id)
                ->where('matiere_id', $matiere->id)
                ->where('user_id', $etudiant->id)->first();
            
            if(!is_null($notes)) {
                $notes->delete();
            }
        }

        flashy()->success('Suppression éffectué !');
        return redirect()->back();  
    }

    public function addPartiel($id) {
        $dataBrute = (new OtherDataService)->notesMatiere($id);
        $classe = $dataBrute[0];
        $matiere = $dataBrute[1];
        $dataNotes = $dataBrute[2];
        return view('personnels.note.add-partiel', compact('classe', 'matiere', 'dataNotes'));
    }

    public function postPartiel(Request $request, $id) {
        $this->validate($request, [
            'session' => 'required|in:partiel_session_1,partiel_session_2',
            'systeme' => 'required|in:lmd,normal',
        ]);

        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $matiere = Matiere::findOrFail($id);
        $request->session == 'partiel_session_1' ? $session = 'partiel_session_1' : $session = 'partiel_session_2';

        foreach($request->except('_token', 'session', 'systeme') as $etudiantId => $notePartiel) {
            $etudiant = User::findOrFail($etudiantId);
            $notes = Note::where('annee_academique_id', $anneeAcademique->id)
                ->where('classe_id', $matiere->classe->id)
                ->where('matiere_id', $matiere->id)
                ->where('user_id', $etudiant->id)->first();

            if(!is_null($notes)) {
                $request->systeme == 'normal' ? $moyenne = (($notes->note_1 +$notes->note_2 + $notes->note_3 + $notePartiel) / 4) : $moyenne = (0.4 * (($notes->note_1 +$notes->note_2 + $notes->note_3) / 3)) + ($notePartiel * 0.6);

                $notes->update([
                    'moyenne' => $moyenne,
                    $session => $notePartiel,
                    'status' => $moyenne >= 10 ? 'admis' : 'ajourné',
                    'systeme_calcul' => $request->systeme,
                ]);
            }
        }

        flashy('Note partiel insérée !');
        return redirect()->route('admin.scolarite-notes-matiere', $matiere->id);
    }

    public function listeClassesPV() {
        $classes = Classe::orderBy('nom', 'ASC')->get();
        return view('personnels.pv.liste-classe-pv', compact('classes'));
    }

    public function pv(Request $request,$id) {
        $this->validate($request, [
            'semestre' => 'required|in:1,2'
        ]);
        $classe = Classe::findOrFail($id);
        $semestre = $request->semestre;
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();

        $pvClasse = (new BulletinService())->pv($id, $request->semestre, 1);
        $entetes = $pvClasse[0];
        $entete4 = $pvClasse[1];
        $dataAllEtudiants = $pvClasse[2];
        return view('personnels.pv.pv', compact('entetes', 'entete4', 'dataAllEtudiants', 'classe', 'semestre', 'anneeAcademique'));
    }

    public function listClasseEtudiants($id) {
        $classe = Classe::findOrFail($id);
        return view('personnels.liste-classe-etudiant', compact('classe'));
    }

    public function affectationEtudiant() {
        $etudiants = User::whereHas('inscriptions', function(Builder $query) {
            $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
            $query->where('annee_academique_id', $anneeAcademique->id)->where('valide', 1);
        })->orderBy('fullname', 'ASC')->get();

        $classes = Classe::orderBy('nom', 'ASC')->get();
        return view('personnels.affectation.affectation-etudiant', compact('etudiants', 'classes'));
    }

    public function affectationListeProf() {
        $profs = Professeur::where('valide', 1)->orderBy('fullname', 'ASC')->get();
        return view('personnels.affectation.affectation-liste-professeur', compact('profs'));
    }

    public function affectationProf($id) {
        $professeur = Professeur::findOrFail($id);
        $matieres = Matiere::orderBy('nom', 'ASC')->get();
        $classes = Classe::orderBy('nom', 'ASC')->get();
        return view('personnels.affectation.affectation-professeur', compact('matieres', 'professeur', 'classes'));
    }

    public function postAffectationEtudiant(Request $request) {
        $this->validate($request, [
            'classe' => 'required|integer',
        ]);

        if(!isset($request->etudiants)) {
            return back()->with("error", "Vous devez selectionner au moins un étudiant !");
        }

        foreach ($request->etudiants as $etudiant) {
            $etudiant = User::findOrFail($etudiant);
            $etudiant->update([
                'classe_id' => $request->classe, 
            ]);
        }

        flashy()->success('Affectation éffectuée !');
        return redirect()->back();
    }

    public function postAffectationProfesseur(Request $request, $id) {
        $this->validate($request, [
            'classe' => 'required|string',
        ]);

        if(!isset($request->matieres)) {
            return back()->with("error", "Vous devez selectionner au moins une matière !");
        }

        $professeur = Professeur::findOrFail($id);
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $classe = Classe::findOrFail($request->classe);

        foreach ($request->matieres as $matiereId) {
            $matiereProfesseur = MatiereProfesseur::where('matiere_id', $matiereId)->where('professeur_id', $professeur->id)->count();
            if (!$matiereProfesseur) {
                $matiere = Matiere::findOrFail($matiereId);
        
                MatiereProfesseur::create([
                    'volume_horaire' => $matiere->volume_horaire,
                    'matiere_id' => $matiere->id,
                    'professeur_id' => $professeur->id,
                    'classe_id' => $classe->id,
                    'annee_academique_id' => $anneeAcademique->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $classeProf = ClasseProfesseur::where('classe_id', $classe->id)->where('professeur_id', $professeur->id)->count();
        if(!$classeProf) {
            ClasseProfesseur::create(
                [
                    'classe_id' => $classe->id,
                    'professeur_id' => $professeur->id,
                    'annee_academique_id' => $anneeAcademique->id,
                ]
            );
        }

        flashy()->success('Affectation éffectuée !');
        return redirect()->back();
    }

    public function chat() {
        $master = 'personnel';
        return view('informatique.chat.chat', compact('master'));
    }
}

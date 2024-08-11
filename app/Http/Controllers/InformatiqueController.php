<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Note;
use App\Models\User;
use App\Models\Salle;
use App\Models\Classe;
use App\Models\Faculte;
// use Barryvdh\DomPDF\PDF;
use App\Models\Matiere;
use App\Exports\PVExport;
use App\Models\Personnel;
use App\Models\Professeur;
use App\Models\Signataire;
use App\Models\Inscription;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use App\Models\AnneeAcademique;
use Illuminate\Validation\Rule;
use App\Models\ClasseProfesseur;
use PhpOffice\PhpWord\IOFactory;
use App\Models\MatiereProfesseur;
use App\Services\BulletinService;
use App\Services\OtherDataService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\SimpleType\Jc;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\StoreEtudiantRequest;

class InformatiqueController extends Controller
{
    public function informatiqueDash() {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $nbrFilieres = Faculte::all()->count();
        $nbrClasses = Classe::count();
        $nbrProfs = Professeur::count();
        $nbrEtudiants = User::whereHas('inscriptions', function(Builder $query) use ($anneeAcademique) {
            $query->where('annee_academique_id', $anneeAcademique->id)->where('valide', 1);
        })->count();
        $nbrPersonnels = Personnel::count();
        $salle = Salle::count();

        $arrayData['nbrFilieres'] = $nbrFilieres;
        $arrayData['nbrClasses'] = $nbrClasses;
        $arrayData['nbrProfs'] = $nbrProfs;
        $arrayData['nbrEtudiants'] = $nbrEtudiants;
        $arrayData['nbrPersonnels'] = $nbrPersonnels;
        $arrayData['salle'] = $salle;

        return view('informatique.dashboard', compact('arrayData'));
    }

    public function profil() {
        return view('informatique.profil.profil');
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
            'email' => $request->email,
            'password' => Hash::make($request->nouveau_password)
        ]);

        flashy()->message('Mot de passe modifié');
        return back()->with("status", "Le mot de passe a été modifié avec succès!");    
    }

    public function listEtudiants() {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();

        // $etudiants = Inscription::where('annee_academique_id', $anneeAcademique->id)
        //     ->with('etudiant')
        //     ->get()
        //     ->pluck('etudiant')
        //     ->sortBy('fullname');
        $etudiants = User::whereHas('inscriptions', function(Builder $query) use ($anneeAcademique){
            $query->where('valide', 1)->where('annee_academique_id', $anneeAcademique->id);
        })->orderBy('fullname', 'asc')->get();

        return view('informatique.etudiants.liste-etudiant', compact('etudiants', 'anneeAcademique'));
    }

    public function listClasseEtudiants($id) {
        $classe = Classe::findOrFail($id);
        Auth::user()->type == 'informaticien' ? $master = 'informatique' : $master = 'personnel';
        return view('informatique.liste-classe-etudiant', compact('classe',  'master'));
    }

    public function listeClasseDownlaod($id) {
        $classe = Classe::findOrFail($id);
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $liste = PDF::loadView('informatique.liste-classe-pdf', compact('classe', 'anneeAcademique'));
        return $liste->stream();
        // return view('informatique.liste-classe-pdf', compact('classe', 'anneeAcademique'));
    }

    public function inscriptionEtudiant() {
        $classes = Classe::orderBy('nom', 'ASC')->get();
        $facultes = Faculte::orderBy('nom', 'ASC')->get();
        return view('informatique.inscription.inscription-form', compact('classes', 'facultes'));
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
            'id_permanent' => $request->id_permanent,
            'numero_table_bac' => $request->numero_table_bac,
            'code_ep' => $request->code_ep,
            'emargement' => $request->emargement,
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

        $etudiant->update(['identifiant_bulletin' => $etudiant->id + 10000]);

        $classe = Classe::findOrFail($request->classe);

        if ($request->statut == 'affecté') {
            $scolarite = $classe->niveauFaculte->scolarite_affecte;
        } else if ($request->statut == 'non affecté') {
            $scolarite = $classe->niveauFaculte->scolarite_nonaffecte;
        }
        else {
            $scolarite = $classe->niveauFaculte->scolarite_reaffecte;    
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
            'classe_id' => $classe->id,
        ]);

        flashy()->message('Etudiant enrégistré !');
        return redirect()->back();
    }

    public function inscriptionEtudiantExistant() {
        $classes = Classe::orderBy('nom', 'ASC')->get();
        $anneeAcademiqueActuelle = getSelectedAnneeAcademique() ?? getLastAnneeAcademique();
        $anneeAcademiquePrecedente = $anneeAcademiqueActuelle->anneeAcademiquePrecedente();

        if($anneeAcademiquePrecedente) {
            $etudiants = User::whereHas('inscriptions', function(Builder $query) use ($anneeAcademiquePrecedente) {
                $query->where('valide', 1)->where('annee_academique_id', $anneeAcademiquePrecedente->id);
            })->orderBy('fullname', 'asc')->get();
        }
        else {
            $etudiants = collect();
        }
        return view('informatique.inscription.inscription-etudiant-existant-form', compact('classes', 'etudiants'));
    }

    public function postInscriptionEtudiantExistant(Request $request) {
        $request->validate([
            'etudiant' => 'required|integer',
            'classe' => 'required|integer',
        ]);

        $etudiant = User::findOrFail($request->etudiant);
        $classe = Classe::findOrFail($request->classe);
        $scolarite = (new OtherDataService)->montantScolarite($etudiant->statut, $classe);
        $anneeAcademique = getSelectedAnneeAcademique() ?? getLastAnneeAcademique();

        Inscription::create([
            'frais_inscription' => $scolarite,
            'net_payer' => $scolarite,
            'user_id' => $etudiant->id,
            'valide' => 1,
            'annee_academique_id' => $anneeAcademique->id,
            'classe_id' => $classe->id,
        ]);

        flashy()->message('Etudiant enrégistré !');
        return redirect()->back();
    }

    public function inscriptionValideeListeEtudiant() {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $etudiants = User::whereHas('inscriptions', function(Builder $query) use ($anneeAcademique){
            $query->where('valide', 1)->where('annee_academique_id', $anneeAcademique->id);
        })->orderBy('fullname', 'asc')->get();
        return view('informatique.inscription.liste-etudiants', compact('etudiants', 'anneeAcademique'));
    }

    public function corbeilleEtudiants() {
        $etudiants = User::orderBy('fullname', 'ASC')->onlyTrashed()->get();
        Auth::user()->type == 'informaticien' ? $master = 'informatique' : $master = 'personnel';

        return view('informatique.inscription.corbeille-etudiants', compact('etudiants', 'master'));
    }

    public function postCorbeilleEtudiants($id) {
        $etudiant = User::withTrashed()->where('id',$id)->first();
        $etudiant->inscriptions->last()->forceDelete();
        User::withTrashed()->where('id',$id)->forceDelete();
        Auth::user()->type == 'informaticien' ? $master = 'informatique' : $master = 'personnel';
        flashy()->message('Etudiant définitivement supprimé !');

        return redirect()->back();
    }

    public function restorationEtudiants($id) {
        User::withTrashed()->find($id)->restore();
        Auth::user()->type == 'informaticien' ? $master = 'informatique' : $master = 'personnel';
        flashy()->message('Restoration !');

        return redirect()->back();
    }


    public function inscriptionDetails($id) {
        $inscription = Inscription::with('etudiant')->findOrFail($id);
        return view('informatique.inscription.inscription-fiche', compact('inscription'));
    }

    public function modifInscriptionForm($inscriptionId) {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $inscription = Inscription::findOrFail($inscriptionId);
        $etudiant = $inscription->etudiant;
        $inscription = Inscription::where('annee_academique_id', $anneeAcademique->id)->where('user_id', $etudiant->id)->first();
        $classes = Classe::orderBy('nom', 'ASC')->get();
        $facultes = Faculte::orderBy('nom', 'ASC')->get();
        return view('informatique.inscription.inscription-modif-form', compact('inscription', 'etudiant', 'classes', 'facultes'));
    }

    public function listeMatiere($inscriptionId) {
        $inscription = Inscription::findOrFail($inscriptionId);
        $etudiant = $inscription->etudiant;
        $anneeAcademique = $inscription->anneeAcademique;
        // $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $data = new OtherDataService;
        $dataNotesSem1 = $data->noteEtudiant($inscription->id, 1);
        $dataNotesSem2 = $data->noteEtudiant($inscription->id, 2);
        $listeNote = PDF::loadView('informatique.note.liste-note-etudiant-pdf',  compact('dataNotesSem1', 'dataNotesSem2', 'etudiant', 'anneeAcademique', 'inscription'));
        return $listeNote->stream();
        // return view('informatique.note.liste-note-etudiant-pdf', compact('dataNotesSem1', 'dataNotesSem2'));
    }

    public function ficheInscriptionPdf($inscriptionId) {

        $inscription = Inscription::findOrFail($inscriptionId);
        $etudiant = $inscription->etudiant;
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $ficheInscription =  PDF::loadView('informatique.inscription.inscription-fiche-pdf', compact('inscription' ,'etudiant', 'anneeAcademique'));
        return $ficheInscription->stream();
        // return view('informatique.inscription.inscription-fiche-pdf');
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
            'id_permanent' => ['required', 'string'],
            'numero_table_bac' => ['required', 'string'],
            'code_ep' => ['required', 'string'],
            'emargement' => ['required', 'string'],
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
            'id_permanent' => $request->id_permanent,
            'numero_table_bac' => $request->numero_table_bac,
            'code_ep' => $request->code_ep,
            'emargement' => $request->emargement,
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

        $classe = Classe::findOrFail($request->classe);

        if ($request->statut == 'affecté') {
            $scolarite = $classe->niveauFaculte->scolarite_affecte;
        } else if ($request->statut == 'non affecté') {
            $scolarite = $classe->niveauFaculte->scolarite_nonaffecte;
        }
        else {
            $scolarite = $classe->niveauFaculte->scolarite_reaffecte;    
        }

        $inscription->update([
            'frais_inscription' => $scolarite,
            'net_payer' => $scolarite,
            'fiche_inscription' => !is_null($request->fiche_inscription) ? $fiche_inscription_path : $inscription->fiche_inscription,
            'fiche_oriantation' => !is_null($request->fiche_oriantation) ? $fiche_oriantation_path : $inscription->fiche_oriantation,
            'extrait_naissance' =>!is_null($request->extrait_naissance) ? $extrait_path : $inscription->extrait_naissance,
            'bac_legalise' => !is_null($request->bac_legalise) ? $bac_legalise_path : $inscription->bac_legalise,
            'cp_note_bac' => !is_null($request->cp_note_bac) ? $cp_note_bac_path : $inscription->cp_note_bac,
            'photo' => !is_null($request->photo) ? $photo_path : $inscription->photo,
            'classe_id' => $request->classe,
        ]);

        flashy()->message('Informations enregistrées avec succès');
        return redirect()->route('admin.inscritpion-detail', $inscription->id);
    }

    public function affectationEtudiant() {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $etudiants = User::whereHas('inscriptions', function(Builder $query) use($anneeAcademique) {
            $query->where('annee_academique_id', $anneeAcademique->id)->where('valide', 1);
        })->orderBy('fullname', 'ASC')->get();

        // dd($etudiants[0]->inscriptions->where('annee_academique_id', $anneeAcademique->id)->first()->classe);
        $classes = Classe::orderBy('nom', 'ASC')->get();
        return view('informatique.affectation.affectation-etudiant', compact('etudiants', 'classes', 'anneeAcademique'));
    }

    public function affectationListeProf() {
        $profs = Professeur::where('valide', 1)->orderBy('fullname', 'ASC')->get();
        return view('informatique.affectation.affectation-liste-professeur', compact('profs'));
    }

    public function affectationProf($id) {
        $professeur = Professeur::findOrFail($id);
        $matieres = Matiere::orderBy('nom', 'ASC')->get();
        $classes = Classe::orderBy('nom', 'ASC')->get();
        return view('informatique.affectation.affectation-professeur', compact('matieres', 'professeur', 'classes'));
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
            $matiere = Matiere::findOrFail($matiereId);
            $matiereProfesseur = MatiereProfesseur::where('annee_academique_id', $anneeAcademique->id)
                ->where('classe_id', $matiere->classe->id)
                ->where('matiere_id', $matiere->id)
                ->where('professeur_id', $professeur->id)
                ->count();
            
            if (!$matiereProfesseur) {        
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

        $classeProf = ClasseProfesseur::where('annee_academique_id', $anneeAcademique->id)->where('classe_id', $classe->id)->where('professeur_id', $professeur->id)->count();
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

    public function listeClassesNotes() {
        $classes = Classe::orderBy('nom', 'DESC')->get();
        return view('informatique.note.liste-classe-note', compact('classes'));
    }

    public function listeMatiereNote($id) {
        $classe = Classe::findOrFail($id);
        $matieres = Matiere::where('classe_id', $classe->id)->orderBy('semestre', 'ASC')->orderBy('nom', 'ASC')->get();
        return view('informatique.note.liste-matieres-notes', compact('classe', 'matieres'));
    }

    public function notesMatiere($id) {
        $dataBrute = (new OtherDataService)->notesMatiere($id);
        $classe = $dataBrute[0];
        $matiere = $dataBrute[1];
        $dataNotes = $dataBrute[2];
        $notesSelectionnees = $dataBrute[3];

        return view('informatique.note.note', compact('classe', 'matiere', 'dataNotes', 'notesSelectionnees'));
    }

    public function listeEtudiantSession2($id) {
        $dataBrute = (new OtherDataService)->notesMatiere($id);
        $classe = $dataBrute[0];
        $matiere = $dataBrute[1];

        $dataNotes = array_filter($dataBrute[2], function($data) {
            return $data['decision_finale'] === 'ajourné';
        });
        // dd($dataBrute);
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $liste = PDF::loadView('informatique.note.liste-ajournes-pdf', compact('classe', 'matiere', 'dataNotes', 'anneeAcademique'));
        return $liste->stream();
        // return view('informatique.note.liste-ajournes-pdf', compact('classe', 'matiere', 'dataNotes'));
    }
    
    public function addNote($id) {
        $dataBrute = (new OtherDataService)->notesMatiere($id);
        $classe = $dataBrute[0];
        $matiere = $dataBrute[1];
        $dataNotes = $dataBrute[2];
        $notes_selectionnees = $dataBrute[3];
        $systemeCalcule = $dataBrute[4];
        return view('informatique.note.note-add', compact('classe', 'matiere', 'dataNotes', 'notes_selectionnees', 'systemeCalcule'));
    }

    public function postNote(Request $request, $id) {
        if(is_null($request->note_1) && is_null($request->note_2) && is_null($request->note_3) && is_null($request->note_4) && is_null($request->note_5) && is_null($request->note_6) && is_null($request->partiel_session_1)) {
            $errors = 'Vous devez selectionner au moins une note';
            return redirect()->back()->withErrors($errors);
        }

        if(!is_null($request->partiel_session_1) && is_null($request->systeme)) {
            $errors = 'Vous devez choisir le systeme de calcul';
            return redirect()->back()->withErrors($errors);
        }

        $noteSelectionnee = [];
        !is_null($request->note_1) ? $noteSelectionnee[] = 'note_1' : '';
        !is_null($request->note_2) ? $noteSelectionnee[] = 'note_2' : '';
        !is_null($request->note_3) ? $noteSelectionnee[] = 'note_3' : '';
        !is_null($request->note_4) ? $noteSelectionnee[] = 'note_4' : '';
        !is_null($request->note_5) ? $noteSelectionnee[] = 'note_5' : '';
        !is_null($request->note_6) ? $noteSelectionnee[] = 'note_6' : '';
        !is_null($request->partiel_session_1) ? $noteSelectionnee[] = 'partiel_session_1' : '';
        
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $matiere = Matiere::findOrFail($id);
        $matiereProfesseur = MatiereProfesseur::with('professeur')
            ->where('annee_academique_id', $anneeAcademique->id)
            ->where('matiere_id', $matiere->id)
            ->where('classe_id', $matiere->classe->id)
            ->first();

        if(!$matiereProfesseur) {
            $errors = 'Cette matiere n\'a pas de professeur ';
            return redirect()->back()->withErrors($errors);
        }
        
        $professeur = $matiereProfesseur->professeur;
        foreach ($request->except('_token', 'note_1', 'note_2', 'note_3', 'note_4', 'note_5', 'note_6', 'partiel_session_1', 'systeme') as $etudiantId => $noteCourantes) {
            // If Etudiant is checked
            if(count($noteCourantes) == 8) {
                $etudiant = User::findOrFail($etudiantId);
                $notes = Note::where('annee_academique_id', $anneeAcademique->id)
                    ->where('classe_id', $matiere->classe->id)
                    ->where('matiere_id', $matiere->id)
                    ->where('user_id', $etudiant->id)->first();
    
                if(!is_null($notes)) {
                    $sommeNote = 0;
                    // If partiel note is added
                    if(!is_null($request->partiel_session_1)) {

                        $allNotes = [];
                        $allNotes['note_1'] = $noteCourantes[1];
                        $allNotes['note_2'] = $noteCourantes[2];
                        $allNotes['note_3'] = $noteCourantes[3];
                        $allNotes['note_4'] = $noteCourantes[4];
                        $allNotes['note_5'] = $noteCourantes[5];
                        $allNotes['note_6'] = $noteCourantes[6];
                        $allNotes['partiel_session_1'] = $noteCourantes[7];

                        $calculMoyenne = (new OtherDataService)->calculMoyenne($request->systeme, $allNotes, $noteSelectionnee);
                        $moyenne = $calculMoyenne[0];
                        $status = $calculMoyenne[1];

                        $notes->update([
                            'note_1' => $noteCourantes[1],
                            'note_2' => $noteCourantes[2],
                            'note_3' => $noteCourantes[3],
                            'note_4' => $noteCourantes[4],
                            'note_5' => $noteCourantes[5],
                            'note_6' => $noteCourantes[6],
                            'notes_selectionnees' => $noteSelectionnee,
                            'moyenne' => $moyenne,
                            'partiel_session_1' => $noteCourantes[7],
                            'status' => $status,
                            'systeme_calcul' => $request->systeme,
                            'professeur_id' => $professeur->id,
                        ]);
                    }
                    else {

                        $allNotes = [];
                        $allNotes['note_1'] = $noteCourantes[1];
                        $allNotes['note_2'] = $noteCourantes[2];
                        $allNotes['note_3'] = $noteCourantes[3];
                        $allNotes['note_4'] = $noteCourantes[4];
                        $allNotes['note_5'] = $noteCourantes[5];
                        $allNotes['note_6'] = $noteCourantes[6];
                        $allNotes['partiel_session_1'] = $noteCourantes[7];

                        $calculMoyenne = (new OtherDataService)->calculMoyenne($request->systeme, $allNotes, $noteSelectionnee);
                        $moyenne = $calculMoyenne[0];
                        $status = $calculMoyenne[1];

                        $notes->update([
                            'note_1' => $noteCourantes[1],
                            'note_2' => $noteCourantes[2],
                            'note_3' => $noteCourantes[3],
                            'note_4' => $noteCourantes[4],
                            'note_5' => $noteCourantes[5],
                            'note_6' => $noteCourantes[6],
                            'notes_selectionnees' => $noteSelectionnee,
                            'moyenne' => $moyenne,
                            'status' => $status,
                            'systeme_calcul' => $request->systeme,
                            'professeur_id' => $professeur->id,
                        ]);
                    }
                }
                else {
                    if(!is_null($request->partiel_session_1)) {

                        $allNotes = [];
                        $allNotes['note_1'] = $noteCourantes[1];
                        $allNotes['note_2'] = $noteCourantes[2];
                        $allNotes['note_3'] = $noteCourantes[3];
                        $allNotes['note_4'] = $noteCourantes[4];
                        $allNotes['note_5'] = $noteCourantes[5];
                        $allNotes['note_6'] = $noteCourantes[6];
                        $allNotes['partiel_session_1'] = $noteCourantes[7];

                        $calculMoyenne = (new OtherDataService)->calculMoyenne($request->systeme, $allNotes, $noteSelectionnee);
                        $moyenne = $calculMoyenne[0];
                        $status = $calculMoyenne[1];
                    }

                    Note::create([
                        'note_1' => $noteCourantes[1],
                        'note_2' => $noteCourantes[2],
                        'note_3' => $noteCourantes[3],
                        'note_4' => $noteCourantes[4],
                        'note_5' => $noteCourantes[5],
                        'note_6' => $noteCourantes[6],
                        'notes_selectionnees' => $noteSelectionnee,
                        'moyenne' => isset($moyenne) ? $moyenne : null,
                        'status' => isset($status) ? $status : null,
                        'partiel_session_1' => !is_null($noteCourantes[7]) ? $noteCourantes[7] : null,
                        'systeme_calcul' => $request->systeme,
                        'classe_id' => $matiere->classe->id,
                        'matiere_id' => $matiere->id,
                        'user_id' => $etudiant->id,
                        'professeur_id' => $professeur->id,
                        'annee_academique_id' => $anneeAcademique->id
                    ]);
                }
            }

        }

        flashy('Notes insérées !');
        return redirect()->route('admin.notes-matiere', $matiere->id);
    }

    public function suppressionNotes($id) {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $matiere = Matiere::findOrFail($id);

        foreach($matiere->classe->etudiants() as $etudiant) {
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

    public function postSession2(Request $request, $id) {
        $this->validate($request, [
            'systeme' => 'required|in:lmd,normal',
        ]);

        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $matiere = Matiere::findOrFail($id);
        // $matiereProfesseur = MatiereProfesseur::with('professeur')->where('annee_academique_id', $anneeAcademique->id)
        //     ->where('matiere_id', $matiere->id)
        //     ->where('classe_id', $matiere->classe->id)
        //     ->first();
        
        // $professeur = $matiereProfesseur->professeur;

        foreach($request->except('_token', 'session', 'systeme') as $etudiantId => $noteSession2) {
            $etudiant = User::findOrFail($etudiantId);
            $notes = Note::where('annee_academique_id', $anneeAcademique->id)
                ->where('classe_id', $matiere->classe->id)
                ->where('matiere_id', $matiere->id)
                ->where('user_id', $etudiant->id)->first();

            if(!is_null($notes)) {
                if(!is_null($notes->notes_selectionnees)) {
                    $sommeNote = 0;
                    $moyenne = 0;
                    if($request->systeme == 'normal') {
                        foreach($notes->notes_selectionnees as $note_x) {
                            $note_x == 'note_1' ? $sommeNote += $notes->note_1 : '';
                            $note_x == 'note_2' ? $sommeNote += $notes->note_2 : '';
                            $note_x == 'note_3' ? $sommeNote += $notes->note_3 : '';
                            $note_x == 'note_4' ? $sommeNote += $notes->note_4 : '';
                            $note_x == 'note_5' ? $sommeNote += $notes->note_5 : '';
                            $note_x == 'note_6' ? $sommeNote += $notes->note_6 : '';
                        }
    
                        $moyenne = $sommeNote + $noteSession2 / (count($notes->notes_selectionnees) + 1);
                    }
                    else {
                        foreach($notes->notes_selectionnees as $note_x) {
                            $note_x == 'note_1' ? $sommeNote += $notes->note_1 : '';
                            $note_x == 'note_2' ? $sommeNote += $notes->note_2 : '';
                            $note_x == 'note_3' ? $sommeNote += $notes->note_3 : '';
                            $note_x == 'note_4' ? $sommeNote += $notes->note_4 : '';
                            $note_x == 'note_5' ? $sommeNote += $notes->note_5 : '';
                            $note_x == 'note_6' ? $sommeNote += $notes->note_6 : '';
                        }
                        $moyenne = (0.4 * ($sommeNote / count($notes->notes_selectionnees))) + ($noteSession2 * 0.6);
                    }
    
                    $notes->update([
                        'moyenne' => $moyenne,
                        'partiel_session_2' => $noteSession2,
                        'status' => $moyenne >= 10 ? 'admis' : 'ajourné',
                        'systeme_calcul' => $request->systeme,
                    ]);
                }
                else {
                    $notes->update([
                        'moyenne' => $noteSession2,
                        'partiel_session_2' => $noteSession2,
                        'status' => $noteSession2 >= 10 ? 'admis' : 'ajourné',
                        'systeme_calcul' => $request->systeme,
                    ]);
                }
            }
            else {
                // Note::create([
                //     'partiel_session_2' => $noteSession2,
                //     'systeme_calcul' => $request->systeme,
                //     'classe_id' => $matiere->classe->id,
                //     'matiere_id' => $matiere->id,
                //     'user_id' => $etudiant->id,
                //     'professeur_id' => $professeur->id,
                //     'annee_academique_id' => $anneeAcademique->id
                // ]);

                dd('SomeThing gone wrong');
            }
            
        }

        flashy('Note Session 2 insérées !');
        return redirect()->back();
    } 

    public function listeClassesBulletin($session) {
        $classes = Classe::where('nom', 'not like', '%bts%')->orderBy('nom', 'ASC')->get();
        $systeme = 'licence';
        return view('informatique.bulletin.liste-classe-bulletin', compact('classes', 'session', 'systeme'));
    }

    public function listeClasseBulletinBTS($session) {
        $classes = Classe::where('nom', 'like', '%bts%')->orderBy('nom', 'asc')->get();
        $systeme = 'bts';
        return view('informatique.bulletin.liste-classe-bulletin', compact('classes', 'session', 'systeme'));
    }

    public function bulletin(Request $request,$id) {
        $this->validate($request, [
            'semestre' => 'required|in:1,2',
            'session' => 'required|in:1,2'
        ]);
        $classe = Classe::findOrFail($id);
        $semestre =  $request->semestre;
        $session =  $request->session;
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $bulletinDatas = $anneeAcademique->id == 1 ? (new BulletinService)->bulletinClasseOld($id, $semestre, $session) : (new BulletinService)->bulletinClasse($id, $semestre, $session);
        $signataire = Signataire::where('signataire', true)->first();
        $view = str_contains(strtolower($classe->nom), 'bts') ? 'informatique.bulletin.bulletin-bts' : 'informatique.bulletin.bulletin';
        return view($view, compact('bulletinDatas', 'classe', 'semestre', 'session','signataire', 'anneeAcademique'));
    }


    public function oneBulletinDownload(Request $request, $id) {
        $this->validate($request, [
            'semestre' => 'required|in:1,2',
            'session' => 'required|in:1,2',
        ]);
        $anneeAcademique = getSelectedAnneeAcademique() ?? getLastAnneeAcademique();

        $etudiant = User::findOrFail($id);
        $classe = $etudiant->classe($anneeAcademique->id);
        $view = str_contains(strtolower($classe->nom), 'bts') ? 'informatique.bulletin.bulletin-bts-pdf' : 'informatique.bulletin.bulletin-un-pdf';

        $dataArray = $request->except('_token', 'semestre', 'session');
        $signataire = Signataire::where('signataire', true)->first();
        $bulletinData = $anneeAcademique->id == 1 ? (new BulletinService)->bulletinEtudiantOld($id, $request->semestre, $request->session) : (new BulletinService)->bulletinEtudiant($id, $request->semestre, $request->session);
        $bulletin = PDF::loadView($view, compact('bulletinData', 'signataire', 'dataArray', 'anneeAcademique'));
        return $bulletin->stream();
        // return view('informatique.bulletin.bulletin-un-pdf', compact('bulletinData'));
    }

    public function allBulletinDownload(Request $request, $id) {
        $this->validate($request, [
            'semestre' => 'required|in:1,2',
            'session' => 'required|in:1,2',
        ]);
        $classe = Classe::findOrFail($id);

        $signataire = Signataire::where('signataire', true)->first();
        $bulletinDatas = (new BulletinService)->bulletinClasse($id, $request->semestre, $request->session);
        $bulletin = PDF::loadView('informatique.bulletin.bulletin-all-pdf', compact('bulletinDatas', 'signataire'));
        return $bulletin->stream();
        // return view('informatique.bulletin.bulletin-all-pdf', compact('bulletinDatas', 'moyennes'));
    }

    public function listeClassesPV($session) {
        $classes = Classe::orderBy('nom', 'ASC')->get();
        return view('informatique.pv.liste-classe-pv', compact('classes', 'session'));
    }

    public function pv(Request $request,$id) {
        $this->validate($request, [
            'semestre' => 'required|in:1,2',
            'session' => 'required|in:1,2'
        ]);

        $classe = Classe::findOrFail($id);
        $semestre = $request->semestre;
        $session = $request->session;
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();

        $pvClasse = $anneeAcademique->id == 1 ? (new BulletinService())->pvOld($id, $request->semestre, $request->session) : (new BulletinService())->pv($id, $request->semestre, $request->session);

        $entetes = $pvClasse[0];
        $dataAllEtudiants = $pvClasse[1];
        $entete4 = $anneeAcademique->id == 1 ? $pvClasse[2] : '';

        return view('informatique.pv.pv', compact('entetes', 'entete4', 'dataAllEtudiants', 'classe', 'semestre', 'anneeAcademique', 'session'));
    }

    public function downloadPV(Request $request, $id) {
        $this->validate($request, [
            'semestre' => 'required|in:1,2',
            'session' => 'required|in:1,2',
        ]);
        $classe = Classe::findOrFail($id);
        // https://docs.laravel-excel.com/3.1/getting-started/
        return Excel::download(new PVExport($id, $request->semestre, $request->session), 'PV '.$classe->nom.'.xlsx');
    }

    public function pvWord(Request $request,$id) {
        $this->validate($request, [
            'semestre' => 'required|in:1,2',
            'session' => 'required|in:1,2',
        ]);

        $classe = Classe::findOrFail($id);
        $semestre = $request->semestre;
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();

        $pvClasse = (new BulletinService())->pv($classe->id, $request->semestre, $request->session);
        $entetes = $pvClasse[0];
        $entete4 = $pvClasse[1];
        $dataAllEtudiants = $pvClasse[2];

        $phpWord = new PhpWord();
        $cellWidth = 500;
        $header = ['size' => 8, 'bold' => true];
        $cellHCentered = ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER];
        $cellVCentered = ['valign' => 'center'];
        // New landscape section
        $section = $phpWord->addSection([
            'orientation' => 'landscape',
            'marginLeft' => 100,
            'marginRight' => 100,
            'marginTop' => 100,
            'marginBottom' => 100
        ]);

        $section->addText('PV DE DELIBERATION // LICENCE 1 DE LETTRES MODERNES // Semestre 1 // 2022 - 2023', $header);
        $tableStyle = [
            'borderSize' => 6,
            'borderColor' => '999999',
            'size' => 6,
        ];

        $phpWord->addTableStyle('Colspan Rowspan', $tableStyle);
        $table = $section->addTable('Colspan Rowspan');

        $row = $table->addRow();
        foreach($entetes[0] as $entete) {
            $row->addCell($cellWidth, [
                'vMerge' => 'restart',
                'gridSpan' => $entete['colspan'],
                'valign' => 'center',
                'alignment' => Jc::CENTER
            ])->addText($entete['nom'], ['size' => 5]);
        }
        $row->addCell($cellWidth)->addText('');

        $row = $table->addRow();
        $row->addCell($cellWidth, ['vMerge' => 'continue']);
        foreach($entetes[1] as $entete) {
            $row->addCell($cellWidth, [
                'vMerge' => 'restart',
                'gridSpan' => $entete['colspan'],
                'valign' => 'center',
                'alignment' => Jc::CENTER
            ])->addText($entete['nom'], ['size' => 5]);
        }
        
        // $section->addPageBreak();

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('pv.docx');
        return response()->download('pv.docx');

    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new UsersExport, 'liste-etudiants.xlsx');
    }

    public function import() {
        return view('informatique.inscription.import-etudiants');
    }
       
    /**
    * @return \Illuminate\Support\Collection
    */
    public function postImport(Request $request)
    {
        $this->validate($request, [
            'liste_etudiants' => 'required|mimes:xls,xlsm,xlsx,csv|max:5120',
        ]);
        
        Excel::import(new UsersImport(), request()->file('liste_etudiants'));
        flashy()->message('Liste importée !');
        return back();
    }

    public function suppressionEtudiant($id) {
        $etudiant = User::findOrFail($id);
        $etudiant->delete();

        flashy()->success('Suppression éffectué !');
        return redirect()->back();    
    }

    public function noteRecalculate() {
        $allNotes = Note::all();

        foreach($allNotes as $notes) {
            if(!is_null($notes->notes_selectionnees)) {
                $sommeNote = 0;
                if($notes->systeme_calcul == 'normal') {
                    foreach($notes->notes_selectionnees as $note_x) {
                        $note_x == 'note_1' ? $sommeNote += $notes->note_1 : '';
                        $note_x == 'note_2' ? $sommeNote += $notes->note_2 : '';
                        $note_x == 'note_3' ? $sommeNote += $notes->note_3 : '';
                        $note_x == 'note_4' ? $sommeNote += $notes->note_4 : '';
                        $note_x == 'note_5' ? $sommeNote += $notes->note_5 : '';
                        $note_x == 'note_6' ? $sommeNote += $notes->note_6 : '';
                    }
    
                    $moyenne = $sommeNote + $notes->partiel_session_1 / (count($notes->notes_selectionnees) + 1);
                }
                else {
                    foreach($notes->notes_selectionnees as $note_x) {
                        $note_x == 'note_1' ? $sommeNote += $notes->note_1 : '';
                        $note_x == 'note_2' ? $sommeNote += $notes->note_2 : '';
                        $note_x == 'note_3' ? $sommeNote += $notes->note_3 : '';
                        $note_x == 'note_4' ? $sommeNote += $notes->note_4 : '';
                        $note_x == 'note_5' ? $sommeNote += $notes->note_5 : '';
                        $note_x == 'note_6' ? $sommeNote += $notes->note_6 : '';
                    }
                    $moyenne = (0.4 * ($sommeNote / count($notes->notes_selectionnees))) + ($notes->partiel_session_1 * 0.6);
                }
    
                $notes->update([
                    'moyenne' => $moyenne,
                    'status' => $moyenne >= 10 ? 'admis' : 'ajourné',
                ]);

            }
            else {
                $notes->update([
                    'moyenne' => $notes->partiel_session_1,
                    // 'partiel_session_2' => $noteSession2,
                    'status' => $notes->partiel_session_1 >= 10 ? 'admis' : 'ajourné',
                    'systeme_calcul' => $notes->systeme,
                ]);
            }
        }

        dd('Note mis à jour !!');
    }

    public function deliberation() {
        $action = "deliberation";
        $anneeAcademique = getSelectedAnneeAcademique() ?? getLastAnneeAcademique();
        return view('informatique.deliberation.deliberation', compact('action', 'anneeAcademique'));
    }

    public function listNoteSecondSession() {
        $action = "liste-note-session2";
        return view('informatique.note.note-session2', compact('action'));  
    }

    public function modifNoteSession2() {
        $action = "modification-note-session-2";
        return view('informatique.note.modification-note-session2', compact('action'));
    }

    public function secondSession() {
        $action = "session2";
        return view('informatique.note.session2', compact('action'));
    }

    public function deliberationSession2() {
        $action = "deliberation-session-2";
        $anneeAcademique = getSelectedAnneeAcademique() ?? getLastAnneeAcademique();
        return view('informatique.deliberation.deliberation-session-2', compact('action', 'anneeAcademique'));
    }

    public function chat() {
        $master = 'informatique';
        return view('informatique.chat.chat', compact('master'));
    }

    public function statistiques() {
        return view('informatique.statistique.statistique');
    }

    public function attestationAdmission() {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $anneeAcademiques = AnneeAcademique::orderBy('id', 'desc')->get();
        $sessions = ['JANVIER','FEVRIER', 'MARS', 'AVRIL', 'MAI', 'JUIN',
            'JUILLET', 'AOUT', 'SEPTEMPBRE', 'OCTOBRE', 'NOVEMBRE', 'DECEMBRE'];
        $mentions = ['INSUFISANT', 'PASSABLE', 'ASSEZ BIEN', ' BIEN', 'TRES BIEN'];
        $etudiants = User::whereHas('inscriptions', function(Builder $query) use ($anneeAcademique){
            $query->where('valide', 1)->where('annee_academique_id', $anneeAcademique->id);
        })->get();

        return view('informatique.documents.attestation-admission', compact('etudiants', 'anneeAcademiques', 'anneeAcademique', 'sessions', 'mentions'));
    }

    public function attestationAdmissionPdf(Request $request) {
        $request->validate([
            'annee_universitaire' => 'required|integer',
            'etudiant' => 'required|integer',
            'session' => 'required|string',
            'annee' => 'required|digits:4',
            'mention' => 'required|string',
            'president' => 'required|string',
        ]);

        $anneUniversitaire = AnneeAcademique::findOrFail($request->annee_universitaire);
        $etudiant = User::findOrFail($request->etudiant);
        $session = $request->session;
        $annee = $request->annee;
        $mention = $request->mention;
        $president = $request->president;

        $attestationAdmission = PDF::loadView('informatique.documents.attestion-adminission-pdf', compact('anneUniversitaire', 'etudiant', 'session', 'annee', 'mention', 'president'));
        return $attestationAdmission->stream();
        // return view('informatique.documents.attestion-adminission-pdf');
    }

    public function showNotes(Request $request) {
        $classe = Classe::findOrFail($request->classe_id);

        foreach($classe->etudiants as $etudiant) {
            if(in_array($etudiant->id, $request->checked)) {

                foreach($etudiant->notes as $note) {
                    $note->update([
                        'show_note' => 1
                    ]);
                }
            }
            else {
                foreach($etudiant->notes as $note) {
                    if($note->show_note) {
                        $note->update([
                            'show_note' => 0
                        ]);
                    }
                }
            }
        }
        
        return response()->json([
            'has_error' => false,
            'message' => 'Done',
        ]);
    }

    public function satistiqueFaculteListe() {
        $facultes = Faculte::where('nom', 'not like', '%bts%')->orderBy('nom', 'ASC')->get();
        return view('informatique.statistique.liste-facultes', compact('facultes'));
    }

    public function statistiquePost(Request $request) {
        $request->validate([
            'session' => 'required|integer|in:1,2',
            'semestre' => 'required|integer|in:1,2',
            'option_stat' => 'required',
            'faculte_id' => 'required|integer',
        ]);

        $faculte = Faculte::findOrFail($request->faculte_id);
        $classes = $faculte->classeNiveau($request->option_stat);
        $session = $request->session;
        $semestre = $request->semestre;
        $option = $request->option_stat;
        $totalFilles = 0;
        $totalFillesAdmises = 0;
        $totalGarcons = 0;
        $totalGarconsAdmis = 0;
        $dataStats = [];

        foreach($classes as $classe) {
            $classeStats = [];
            $bulletinDatas = (new BulletinService)->bulletinClasse($classe->id, $semestre, $session);

            $classeStats['classe'] = $classe->nom;
            $classeStats['admis'] = count(array_filter($bulletinDatas, function($item) use (&$totalFilles, &$totalFillesAdmises, &$totalGarcons, &$totalGarconsAdmis) {
                if($item['sexe'] == 'feminin')
                    $totalFilles += 1;

                if($item['sexe'] == 'feminin' && $item['moyenne_finale'] >= 10)
                    $totalFillesAdmises += 1;

                if($item['sexe'] == 'masculin')
                    $totalGarcons += 1;

                if($item['sexe'] == 'masculin' && $item['moyenne_finale'] >= 10)
                    $totalGarconsAdmis += 1;

                return $item['moyenne_finale'] >= 10;
            }));
            $classeStats['ajournes'] = count($bulletinDatas) - $classeStats['admis'];

            array_push($dataStats, $classeStats);
        }

        return view('informatique.statistique.statistique', compact('faculte', 'option', 'session', 'semestre', 'dataStats', 'totalFilles', 'totalFillesAdmises', 'totalGarcons', 'totalGarconsAdmis'));
        
    }

    public function statistiquesSession(Request $request) {
        $request->validate([
            'session' => 'required|integer|in:1,2',
            'semestre' => 'required|integer|in:1,2'
        ]);

        $classes = Classe::orderBy('nom')->get();
        $session = $request->session;
        $semestre = $request->semestre;
        $dataStats = [];
        foreach($classes as $classe) {
            $classeStats = [];
            $bulletinDatas = (new BulletinService)->bulletinClasse($classe->id, $semestre, $session);

            $classeStats['classe'] = $classe->nom;
            $classeStats['admis'] = count(array_filter($bulletinDatas, function($item) {
                return $item['moyenne_finale'] >= 10;
            }));
            $classeStats['ajournes'] = count($bulletinDatas) - $classeStats['admis'];

            array_push($dataStats, $classeStats);
        }

        return view('informatique.statistique.statistique', compact('session', 'semestre', 'dataStats'));
    }
    /**
     * 
     * Cette fonction est faite pour corriger le fait que certains 
     * étudiants aient des notes dans des classes qui ne sont pas 
     * les leurs.
     */
    public function pureNotes() {

        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $notes = Note::where('annee_academique_id', $anneeAcademique->id)->get();

        foreach($notes as $note) {
            if(is_null($note->etudiant)) {
                $note->delete();
            }
        }

        $notes = Note::where('annee_academique_id', $anneeAcademique->id)->get();

        foreach($notes as $note) {
            if($note->classe_id !== $note->etudiant->classe_id) {
                $note->delete();
            }

        }
        dd('Note purifié');
    }

    /**
     * Cette fonction ajoute la chaine 'partiel_session_1' au champ 'notes_selectionne'
     * dans la table notes
     */

    public function addNoteSelectionnee() {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $notes = Note::where('annee_academique_id', $anneeAcademique->id)->get();

        foreach($notes as $note) {
            $notes_selectionnees = [];
            if(!is_null($note->partiel_session_1) && !is_null($note->notes_selectionnees) && !in_array('partiel_session_1', $note->notes_selectionnees)) {
                $notes_selectionnees = $note->notes_selectionnees;
                $notes_selectionnees[] = 'partiel_session_1';
                $note->update([
                    'notes_selectionnees' => $notes_selectionnees,
                ]); 
            }
            if(!is_null($note->partiel_session_1) && is_null($note->notes_selectionnees)) {
                $notes_selectionnees[] = 'partiel_session_1';
                // dd($notes_selectionnees);
                $note->update([
                    'notes_selectionnees' => $notes_selectionnees,
                ]); 
            }
        }
        
        dd('partiel_session_1 ajouté !!!!!');
    }

    public function transfereClasseIdInInscription() {
        $inscriptions = Inscription::all();
        foreach($inscriptions as $inscription) {
            if($inscription->etudiant) {
                $inscription->update([
                    'classe_id' => $inscription->etudiant->classe_id
                ]);
    
                $inscription->etudiant->update([
                    'classe_id' => null
                ]);
            }
        }

        dd('Transfert classe_id ok');
    }

    public function createIdentifiantBulletin() {
        $etudiants = User::all();

        foreach($etudiants as $etudiant) {
            $etudiant->update(['identifiant_bulletin' => $etudiant->id + 10000]);
        }

        dd('Identifiant Bulletin étudiant ok');
    }
}

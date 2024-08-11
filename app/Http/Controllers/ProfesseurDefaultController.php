<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Models\Cours;
use App\Models\Classe;
use App\Models\Faculte;
use App\Models\Matiere;
use App\Models\Presence;
use App\Models\HeureAbsence;
use Illuminate\Http\Request;
use App\Models\ResourcesCours;
use App\Models\AnneeAcademique;
use App\Models\MatiereProfesseur;
use App\Services\ScheduleService;
use App\Services\OtherDataService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfesseurDefaultController extends Controller
{
    public function profDashboard() {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $progressions = [];
        
        foreach (Auth::user()->matieres as $matiere) {
            $honoraire = 0;
            $niveauFaculteId = $matiere->classe->niveauFaculte->id ?? 0;
            $classe = Classe::where('niveau_faculte_id', $niveauFaculteId)->first();

            if (isset($classe)) {
                // if ($classe->systeme == 'bts') {
                //     $honoraire = Auth::user()->taux_horaire_bts * $matiere->volume_horaire;
                // }
                // else {
                //     if ($classe->niveauFaculte->nom == 'licence 1' || $classe->niveauFaculte->nom == 'licence 2' || $classe->niveauFaculte->nom == 'licence 3') {
                //         $honoraire = Auth::user()->taux_horaire_licence * $matiere->volume_horaire;
                //     }
                //     else {
                //         $honoraire = Auth::user()->taux_horaire_master * $matiere->volume_horaire;
                //     }
                // }
                $pourcentage = ($matiere->pivot->progression * 100) / $matiere->pivot->volume_horaire;
                array_push($progressions,[
                    'pourcentage' => $pourcentage,
                    'progression' => $matiere->pivot->progression,
                    'nom_matiere' => $matiere->nom,
                    'nom_classe' => $classe->nom ?? 'No classe',
                    'volume_horaire' => $matiere->volume_horaire,
                    'honoraire' => 0,
                    // 'honoraire' => $honoraire,
                    'systeme' => $classe->systeme
                ]);
            }
        }

        return view('professeur.dashboard', compact('progressions'));
    }

    public function enregistrement() {
        $facultes = Faculte::orderBy('nom', 'ASC')->get();
        return view('professeur.enregistrement.form', compact('facultes'));
    }

    public function postEnregistrement(Request $request) {
        $this->validate($request,[
            'nom_prenom' => 'required|string',
            'numero' => 'required|digits:10|unique:professeurs,numero,'. Auth::id(),
            'email' => 'required|email|unique:professeurs,email,'. Auth::id(),
            'postale' => 'nullable|string',
            'date_naissance' => 'required|date',
            'profession' => 'required|string',
            'statut' => 'required|string',
            'anciennete' => 'required|integer',
            'numero_cnps' => 'nullable|string',
            'matieres' => 'nullable|array',
            'piece_indentite' => 'nullable|mimes:pdf',
            'cv' => 'nullable|mimes:pdf',
            'diplomes' => 'nullable|mimes:pdf',
            'autorisation_enseigner' => 'nullable|mimes:pdf',
            'soumettre' => 'required|integer',          
        ]);

        if (!is_null($request->piece_indentite)) {
            if(is_null(Auth::user()->piece_identite)) {
                $piece_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_piece_indentite.' . $request->piece_indentite->extension();
                $piece_path = $request->piece_indentite->storeAs('public/professeurs/pieces_identite', $piece_name);
            }
            else {
                $piece_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_piece_indentite.' . $request->piece_indentite->extension();
                Storage::delete(Auth::user()->piece_identite);
                $piece_path = $request->piece_indentite->storeAs('public/professeurs/pieces_identite', $piece_name);
            }
        }

        if (!is_null($request->cv)) {
            if (is_null(Auth::user()->cv)) {
                $cv_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_cv.' . $request->cv->extension();
                $cv_path = $request->cv->storeAs('public/professeurs/cv', $cv_name);
            } 
            else {
                $cv_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_cv.' . $request->cv->extension();
                Storage::delete(Auth::user()->cv);
                $cv_path = $request->cv->storeAs('public/professeurs/cv', $cv_name);
            }
        }

        if (!is_null($request->diplomes)) {
            if (is_null(Auth::user()->diplomes)) {
                $diplomes_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_diplomes.' . $request->diplomes->extension();
                $diplomes_path = $request->diplomes->storeAs('public/professeurs/diplomes', $diplomes_name);
            } 
            else {
                $diplomes_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_diplomes.' . $request->diplomes->extension();
                Storage::delete(Auth::user()->diplomes);
                $diplomes_path = $request->diplomes->storeAs('public/professeurs/diplomes', $diplomes_name);
            }
        }

        if (!is_null($request->autorisation_enseigner)) {
            if (is_null(Auth::user()->autorisation_enseigner)) {
                $autorisations_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_autorisations.' . $request->autorisation_enseigner->extension();
                $autorisations_path = $request->autorisation_enseigner->storeAs('public/professeurs/autorisations', $autorisations_name);
            } else {
                $autorisations_name = str_replace(' ', '_', Auth::user()->fullname). '_' . time() . '_autorisations.' . $request->autorisation_enseigner->extension();
                Storage::delete(Auth::user()->autorisation_enseigner);
                $autorisations_path = $request->autorisation_enseigner->storeAs('public/professeurs/autorisations', $autorisations_name);
            }            
        }

        Auth::user()->update([
            'fullname' => $request->nom_prenom,
            'numero' => $request->numero,
            'email' => $request->email,
            'postale' => $request->postale,
            'date_naissance' => $request->date_naissance,
            'profession' => $request->profession,
            'statut' => $request->statut,
            'cnps' => $request->numero_cnps,
            'anciennete' => $request->anciennete,
            'modules_enseignes' => $request->matieres,
            'piece_identite' => $piece_path ?? Auth::user()->piece_identite,
            'cv' => $cv_path ?? Auth::user()->cv,
            'diplomes' => $diplomes_path ?? Auth::user()->diplomes,
            'autorisation_enseigner' => $autorisations_path ?? Auth::user()->autorisation_enseigner,
            'soumettre' => $request->soumettre,
        ]);

        $success = $request->soumettre == 1 ? 'success' : 'fail';
        return redirect()->back()->with('success', $success);
    }

    public function classeDetailsPresence($id) {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $classe = Classe::findOrFail($id);
        $matiereProfesseurs = MatiereProfesseur::with('matiere')->where('annee_academique_id', $anneeAcademique->id)
            ->where('professeur_id', Auth::id())->where('classe_id', $classe->id)->get();
        return view('professeur.classe-presence', compact('matiereProfesseurs'));
    }

    public function classeDetailsPresenceConsultation($id) {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $classe = Classe::findOrFail($id);
        $matiereProfesseurs = MatiereProfesseur::with('matiere')->where('annee_academique_id', $anneeAcademique->id)
            ->where('professeur_id', Auth::id())->where('classe_id', $classe->id)->get();
        return view('professeur.classe-presence-consultation', compact('matiereProfesseurs'));
    }

    public function listePresence($id) {
        $matiere = Matiere::findOrFail($id);
        $etudiants = User::where('classe_id', $matiere->classe->id)->get();
        return view('professeur.liste-presence', compact('matiere', 'etudiants'));
    }

    public function postListePresence(Request $request, $id) {
        $this->validate($request, [
            'duree_cours' => 'required|integer',
        ]);

        $matiere = Matiere::findOrFail($id);
        $listePresence = [];
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();

        foreach ($request->except('_token', 'matiere_id', 'duree_cours') as $id_etudiant => $presenceBool) {
            $etudiant = User::findOrFail($id_etudiant);
            $listePresence[$etudiant->fullname] = $presenceBool;
            
            // Si étudiant absent
            if($presenceBool == 0) {
                HeureAbsence::create([
                    'heure_absence' => $request->duree_cours,
                    'user_id' => $etudiant->id,
                    'matiere_id' => $matiere->id,
                    'annee_academique_id' => $anneeAcademique->id,
                ]);
            // Envoie message d'absence étudiant au parent
            }
        }

        ksort($listePresence);
        Presence::create([
            'liste' => $listePresence,
            'classe_id' => $matiere->classe->id,
            'matiere_id' => $matiere->id,
            'annee_academique_id' => $anneeAcademique->id,
        ]);

        flashy()->message('Appel effectué !');
        return redirect()->route('prof.classe-details-presence', $matiere->classe->id);
    }

    public function consultationListePresence($id) {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $matiere = Matiere::findOrFail($id);
        $presences = Presence::where('annee_academique_id', $anneeAcademique->id)->where('classe_id', $matiere->classe->id)->where('matiere_id', $matiere->id)->get();
        $liste = $presences[0]->liste;
        // ksort($liste);
        // dd($liste);
        return view('professeur.consultation-liste-presence', compact('presences'));
    }

    public function classeNote($id) {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $classe = Classe::findOrFail($id);
        $matiereProfesseurs = MatiereProfesseur::with('classe', 'matiere')->where('annee_academique_id', $anneeAcademique->id)->where('classe_id', $classe->id)->where('professeur_id', Auth::id())->get();
        return view('professeur.classe-note', compact('matiereProfesseurs'));
    }

    public function note($id) {        
        $dataBrute = (new OtherDataService)->notesMatiere($id);
        $classe = $dataBrute[0];
        $matiere = $dataBrute[1];
        $dataNotes = $dataBrute[2];
        $disableAddNote = '';

        foreach($dataNotes as $dataNote) {
            if($dataNote['note_3'] !== 'NONE') {
                $disableAddNote = '#';
                break;
            }
        }
        return view('professeur.note.note', compact('classe', 'matiere', 'dataNotes', 'disableAddNote'));
    }

    public function addNote($id) {
        $dataBrute = (new OtherDataService)->notesMatiere($id);
        $classe = $dataBrute[0];
        $matiere = $dataBrute[1];
        $dataNotes = $dataBrute[2];
        $notes_selectionnees = $dataBrute[3];

        return view('professeur.note.note-add', compact('classe', 'matiere', 'dataNotes', 'notes_selectionnees'));
    }

    public function postNote(Request $request, $id) {
        if(is_null($request->note_1) && is_null($request->note_2) && is_null($request->note_3) && is_null($request->note_4) && is_null($request->note_5) && is_null($request->note_6)) {
            $errors = 'Vous devez selectionner au moins une note';
            return redirect()->back()->withErrors($errors);
        }
        
        $this->validate($request, [
            'note_1' => 'required',
        ]);
        $noteSelectionnee = [];
        !is_null($request->note_1) ? $noteSelectionnee[] = 'note_1' : '';
        !is_null($request->note_2) ? $noteSelectionnee[] = 'note_2' : '';
        !is_null($request->note_3) ? $noteSelectionnee[] = 'note_3' : '';
        !is_null($request->note_4) ? $noteSelectionnee[] = 'note_4' : '';
        !is_null($request->note_5) ? $noteSelectionnee[] = 'note_5' : '';
        !is_null($request->note_6) ? $noteSelectionnee[] = 'note_6' : '';

        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $matiere = Matiere::findOrFail($id);
        $matiereProfesseur = MatiereProfesseur::with('professeur')->where('annee_academique_id', $anneeAcademique->id)
            ->where('matiere_id', $matiere->id)
            ->where('classe_id', $matiere->classe->id)
            ->first();
        
        $professeur = $matiereProfesseur->professeur;
        foreach ($request->except('_token', 'note_1', 'note_2', 'note_3', 'note_4', 'note_5', 'note_6') as $etudiantId => $noteCourantes) {
            $etudiant = User::findOrFail($etudiantId);
            $notes = Note::where('annee_academique_id', $anneeAcademique->id)
                ->where('classe_id', $matiere->classe->id)
                ->where('matiere_id', $matiere->id)
                ->where('user_id', $etudiant->id)->first();

            if(!is_null($notes)) {
                $sommeNote = 0;
                if($notes->systeme_calcul == 'normal') {
                    foreach($noteSelectionnee as $note_x) {
                        $note_x == 'note_1' ? $sommeNote += $notes->note_1 : '';
                        $note_x == 'note_2' ? $sommeNote += $notes->note_2 : '';
                        $note_x == 'note_3' ? $sommeNote += $notes->note_3 : '';
                        $note_x == 'note_4' ? $sommeNote += $notes->note_4 : '';
                        $note_x == 'note_5' ? $sommeNote += $notes->note_5 : '';
                        $note_x == 'note_6' ? $sommeNote += $notes->note_6 : '';
                    }

                    $moyenne = $sommeNote + $notes->partiel_session_1 / (count($noteSelectionnee) + 1);
                }
                else {
                    foreach($noteSelectionnee as $note_x) {
                        $note_x == 'note_1' ? $sommeNote += $notes->note_1 : '';
                        $note_x == 'note_2' ? $sommeNote += $notes->note_2 : '';
                        $note_x == 'note_3' ? $sommeNote += $notes->note_3 : '';
                        $note_x == 'note_4' ? $sommeNote += $notes->note_4 : '';
                        $note_x == 'note_5' ? $sommeNote += $notes->note_5 : '';
                        $note_x == 'note_6' ? $sommeNote += $notes->note_6 : '';
                    }
                    $moyenne = (0.4 * ($sommeNote / count($noteSelectionnee))) + ($notes->partiel_session_1 * 0.6);
                }

                $notes->update([
                    'note_1' => $noteCourantes[0],
                    'note_2' => $noteCourantes[1],
                    'note_3' => $noteCourantes[2],
                    'note_4' => $noteCourantes[3],
                    'note_5' => $noteCourantes[4],
                    'note_6' => $noteCourantes[5],
                    'notes_selectionnees' => $noteSelectionnee,
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
                    'note_4' => $noteCourantes[3],
                    'note_5' => $noteCourantes[4],
                    'note_6' => $noteCourantes[5],
                    'notes_selectionnees' => $noteSelectionnee,
                    'classe_id' => $matiere->classe->id,
                    'matiere_id' => $matiere->id,
                    'user_id' => $etudiant->id,
                    'professeur_id' => $professeur->id,
                    'annee_academique_id' => $anneeAcademique->id
                ]);
            }
        }

        flashy('Note inséré !');
        return redirect()->route('prof.notes', $matiere->id);
    }

    public function schedule(ScheduleService $scheduleService) {
        $jours = Cours::JOURS;
        $donneesCalendrier = $scheduleService->genererProfesseurDonneesCalendrier($jours, Auth::id());

        return view('professeur.maquette', compact('jours', 'donneesCalendrier'));
    }

    public function ressourcesIndex() {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $allData = [];
        foreach(Auth::user()->classes as $classe) {
            $matieres = [];
            $matiereProfesseurs = MatiereProfesseur::with('matiere')
                ->where('annee_academique_id', $anneeAcademique->id)
                ->where('professeur_id', Auth::id())
                ->where('classe_id', $classe->id)
                ->get();

                foreach($matiereProfesseurs as $matiereProfesseur) {
                    array_push($matieres, [
                        'matiere_id' => $matiereProfesseur->matiere->id ?? '#',
                        'matiere_nom' => $matiereProfesseur->matiere->nom ?? 'NONE',
                    ]);
                }

            array_push($allData, [
                'classe_id' => $classe->id,
                'classe_nom' => $classe->nom,
                'matieres' => $matieres,
            ]);
        }
        return view('professeur.resources.index', compact('allData'));
    }

    public function ressourcesShow(Request $request) {
        $this->validate($request, [
            'classe' => 'required|integer',
            'matiere' => 'required|integer',
        ]);

        $matiere = Matiere::findOrFail($request->matiere);
        $classe = Classe::findOrFail($request->classe);

        $ressources = ResourcesCours::where('matiere_id', $matiere->id)
        ->where('classe_id', $classe->id)
        ->where('professeur_id', Auth::id())->get();

        return view('professeur.resources.show', compact('ressources', 'matiere'));
    }

    public function ressourcesUploadForm() {
        $matieres = [];

        foreach ( Auth::user()->matieres as $matiere) {
           $classe = Classe::findOrFail($matiere->pivot->classe_id);
           $matieres[$matiere->id . '|' . $classe->id] = $matiere->nom . ' | ' . $classe->nom;
        }
        return view('professeur.resources.create', compact('matieres'));
    }

    public function ressourcesUploadFormPost(Request $request) {
        $this->validate($request, [
            'matiere' => 'required',
            'nom' => 'required|string',
            'description' => 'nullable|string',
            'document' => 'required|mimes:pdf,doc,docx'
        ]);

        $matiere_id = explode('|', $request->matiere)[0];
        $classe_id = explode('|', $request->matiere)[1];
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $docName = $request->nom .'.' . $request->document->extension();
        $docPath = $request->document->storeAs('public/resources', $docName);

        ResourcesCours::create([
            'nom' => $docName,
            'description' => $request->description,
            'path' => $docPath,
            'matiere_id' => $matiere_id,
            'classe_id' => $classe_id,
            'professeur_id' => Auth::id(),
            'annee_academique_id' => $anneeAcademique->id,
        ]);

        flashy()->message('Cours chargé avec succès !');
        return redirect()->back();
    }

    public function profil() {
        return view('professeur.profil.profil');
    }

    public function changePassword(Request $request) {
        $this->validate($request, [
            'email' => 'required|email|unique:professeurs,email,'. Auth::id(),
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

    public function changeInformationsPost(Request $request) {
        $this->validate($request, [
            'nom_prenoms' => 'required|string',
            'numero' => 'required|digits:10|unique:professeurs,numero,' . Auth::id(),
        ]);

        Auth::user()->update([
            'fullname' => $request->nom_prenoms,
            'numero' => $request->numero,
        ]);

        flashy()->message('Information enrégistrées !');
        return redirect()->back();
    }
}

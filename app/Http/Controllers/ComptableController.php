<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\User;
// use Illuminate\Support\Facades\NumberFormatter;
// use NumberFormatter;
use NumberFormatter;
use App\Models\Faculte;
use setasign\Fpdi\Fpdi;
use App\Models\Scolarite;
use App\Models\Echeancier;
use App\Models\Professeur;
use App\Models\Inscription;
use Illuminate\Http\Request;
use App\Models\AnneeAcademique;
use App\Models\PaiementProfesseur;
use App\Services\OtherDataService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\ProfesseurDataService;
use Illuminate\Database\Eloquent\Builder;


class ComptableController extends Controller
{
    public function dashboard() {
        // Année Universitaire en cours
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $dataProfesseurs = (new ProfesseurDataService())->professeurData();

        // Data pour le dash
        $dataDash = [];
        $dataDash['sommeTotale'] = 0;
        $dataDash['sommePaye'] = 0;
        $dataDash['depenseProfesseur'] = $dataProfesseurs['depenseProfesseur'];
        $dataDash['TotalVolumeHoraire'] = $dataProfesseurs['TotalVolumeHoraire'];
        // $dataDash['volumeHoraireBTS'] = $dataProfesseurs['volumeHoraireBTS'];
        // $dataDash['prixHoraireBTS'] = $dataProfesseurs['prixHoraireBTS'];
        // $dataDash['volumeHoraireLicence'] = $dataProfesseurs['volumeHoraireLicence'];
        // $dataDash['prixHoraireLicence'] = $dataProfesseurs['prixHoraireLicence'];
        // $dataDash['volumeHoraireMaster'] = $dataProfesseurs['volumeHoraireMaster'];
        // $dataDash['prixHoraireMaster'] = $dataProfesseurs['prixHoraireMaster'];
        $dataDash['nombreProfeseurs'] = $dataProfesseurs['nombreProfeseurs'];
                
        // Appel des étudiants inscris pour l'année académique en cours
        $etudiants = User::whereHas('inscriptions', function(Builder $query) use ($anneeAcademique) {
            $query->where('valide', 1)->where('annee_academique_id', $anneeAcademique->id);
        })->get();

        $dataDash['nbrEtudiants'] = $etudiants->count();

        // Sommes payées et sommes totales
        foreach ($etudiants as $etudiant) {
            $dataDash['sommeTotale'] += $etudiant->inscriptions->last()->net_payer;
            $dataDash['sommePaye'] += Scolarite::where('annee_academique_id', $anneeAcademique->id)->where('user_id', $etudiant->id)->sum('versement');
        }

        $dataDash['sommeRestante'] = $dataDash['sommeTotale'] - $dataDash['sommePaye'];

        if ($dataDash['sommeTotale']) {
            $dataDash['pourcentage'] = ($dataDash['sommePaye'] * 100) / $dataDash['sommeTotale'];
        } else {
            $dataDash['pourcentage'] = 0;
        }

        return view('comptable.dashboard', compact('dataDash'));
    }

    public function detailsTotalScolarite() {
        $comingData = new OtherDataService();
        $scolariteClasseData = $comingData->scolariteByClasse();
        return view('comptable.scolarite.details-total-scolarite', compact('scolariteClasseData'));
    }

    public function detailsScolaritePaye() {
        $comingData = new OtherDataService();
        $scolariteClasseData = $comingData->scolaritePayerByClasse();
        return view('comptable.scolarite.details-total-scolarite', compact('scolariteClasseData'));
    }

    public function detailsScolariteRestante() {
        $comingData = new OtherDataService();
        $scolariteClasseData = $comingData->scolariteRestanteByClasse();
        return view('comptable.scolarite.details-total-scolarite', compact('scolariteClasseData'));
    }

    public function profil() {
        return view('comptable.profil.profil');
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

    public function listeEtudiantInscription() {
        $anneeAcademique = getSelectedAnneeAcademique() ?? getLastAnneeAcademique();
        $etudiants = User::whereHas('inscriptions', function(Builder $query) use ($anneeAcademique) {
            $query->where('valide', 1)->where('annee_academique_id', $anneeAcademique->id);
        })->get();
        return view('comptable.inscription.liste-etudiant-inscription', compact('etudiants', 'anneeAcademique'));
    }

    public function attestionInscription($id) {
        $etudiant = User::findOrFail($id);
        $reference = $etudiant->niveauFiliere->nom . ' : ' . $etudiant->niveauFiliere->filiere->nom;
        $date_naissance = explode('-', $etudiant->date_naissance)[2] . ' / ' . explode('-', $etudiant->date_naissance)[1] . ' / ' . explode('-', $etudiant->date_naissance)[0];
        $anneeAcademique = $etudiant->inscriptions->last()->anneeAcademique->debut . ' - ' . $etudiant->inscriptions->last()->anneeAcademique->fin;
        $pdf = new Fpdi();

        // Add a page
        $pdf->AddPage();

        //Setting font
        $pdf->SetFont('helvetica', '', 14);

        // Set source file
        $pdfPath = storage_path('app/templates/attestation_inscription.pdf');
        $pdf->setSourceFile($pdfPath);
        $tplId = $pdf->importPage(1);

        // use the imported page and place it at point 10,10 with a width of 100 mm
        // $pdf->useImportedPage($tplId, 0, 0, 198);

        $pdf->useTemplate($tplId, null, null, null, 300, null);

        $pdf->SetXY(50, 132);
        $pdf->Write(0, $etudiant->fullname);

        $pdf->SetXY(35, 142);
        $pdf->Write(0, $date_naissance);
        
        $pdf->SetXY(75, 142);
        $pdf->Write(0, $etudiant->lieu_naissance);

        $pdf->SetXY(21, 158);
        $pdf->Write(0, $reference);

        $pdf->SetXY(75, 166);
        $pdf->Write(0, $etudiant->matricule_etudiant);

        $pdf->SetXY(75, 176);
        $pdf->Write(0, $anneeAcademique);

        // Output results  I: Direct input ,D: Download the file ,F: Save to local file ,S: Return string 
        $pdf->Output('I', 'Attestation d\'inscription');

    }

    public function dossierIndividuel($id) {
        $etudiant = User::findOrFail($id);
        $pdf = new Fpdi();

        // Add a page
        $pdf->AddPage();

        //Setting font
        $pdf->SetFont('helvetica', '', 14);

        // Set source file
        $pdfPath = storage_path('app/templates/dossier_individuel.pdf');
        $pdf->setSourceFile($pdfPath);
        $tplId = $pdf->importPage(1);

        // use the imported page and place it at point 10,10 with a width of 100 mm
        // $pdf->useImportedPage($tplId, 0, 0, 198);
        $pdf->useTemplate($tplId, null, null, null, 300, null);

        // $pdf->SetXY(50, 132);
        // $pdf->Write(0, $etudiant->fullname);

        // Output results  I: Direct input ,D: Download the file ,F: Save to local file ,S: Return string 
        $pdf->Output('I', 'Dossier individuel');
    }

    public function etudiantInscription($id) {
        $inscription = Inscription::findOrFail($id);
        $anneeAcademique = getSelectedAnneeAcademique() ?? getLastAnneeAcademique();
        return view('comptable.inscription.inscription-fiche', compact('inscription', 'anneeAcademique'));
    }

    public function etudiantInscriptionPost(Request $request, $id) {
        $this->validate($request, [
            'nom_banque' => 'required|string',
            'numero_bordereau' => 'required|string',
            'date_versement' => 'required|date',
            'numero_recu_inscription' => 'required|string',
            'montant_frais_inscription' => 'required|numeric',
            'numero_recu_scolarite' => 'required|string|unique:scolarites,numero_recu',
            'montant_frais_scolarite' => 'required|numeric',
        ]);

        $inscription = Inscription::findOrFail($id);
        $inscription->update([
            'frais_inscription' => $request->montant_frais_inscription,
            'nom_banque' => $request->nom_banque,
            'numero_bordereau' => $request->numero_bordereau,
            'numero_recu' => $request->numero_recu_inscription,
            'date_versement' => $request->date_versement,
        ]);

        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();

        $payee = $inscription->etudiant->scolarites->sum('versement') + $request->montant_frais_scolarite;
        $reste = $inscription->etudiant->niveauFiliere->scolarite - $payee;
        
        $lastScolarite = Scolarite::all()->last();
        if (!is_null($lastScolarite)) {
            Scolarite::create([
                'nom_banque' => $request->nom_banque,
                'numero_bordereau' => $request->numero_bordereau,
                'code_caisse' => $lastScolarite->code_caisse + 1,
                'numero_recu' => $request->numero_recu_scolarite,
                'date_versement' => $request->date_versement,
                'versement' => $request->montant_frais_scolarite,
                'montant_scolarite' => $inscription->etudiant->niveauFiliere->scolarite,
                'payee' => $payee,
                'reste' => $reste,
                'user_id' => $inscription->etudiant->id,
                'annee_academique_id' => $anneeAcademique->id,
            ]);
        }
        else {
            Scolarite::create([
                'nom_banque' => $request->nom_banque,
                'numero_bordereau' => $request->numero_bordereau,
                'code_caisse' => 1,
                'numero_recu' => $request->numero_recu_scolarite,
                'date_versement' => $request->date_versement,
                'versement' => $request->montant_frais_scolarite,
                'montant_scolarite' => $inscription->etudiant->niveauFiliere->scolarite,
                'reste' => $inscription->etudiant->niveauFiliere->scolarite - $request->montant_frais_scolarite,
                'user_id' => $inscription->etudiant->id,
                'annee_academique_id' => $anneeAcademique->id,
            ]);
        }

        flashy()->message('Information enrégistrée avec succès !');
        return redirect()->back();
    }

    public function validerInscription($id) {
        $inscription = Inscription::findOrFail($id);
        $inscription->update([
            'valide' => 1,
            'date_inscription' => now(),
        ]);

        flashy()->message('Inscription validée !');
        return redirect()->back();
    }

    public function refusInscription(Request $request, $id) {
        $this->validate($request, [
            'motif' => 'required|string',
        ]);

        $inscription = Inscription::findOrFail($id);
        $inscription->update([
            'raison' => $request->motif,
        ]);

        flashy()->error('Inscription refusé !');
        return redirect()->back();
    }

    public function listeEtudiantScolarite() {
        $anneeAcademique = getSelectedAnneeAcademique() ?? getLastAnneeAcademique();

        $etudiants = User::whereHas('inscriptions', function(Builder $query) use ($anneeAcademique) {
            $query->where('valide', 1)->where('annee_academique_id', $anneeAcademique->id);
        })->orderBy('fullname', 'ASC')->get();
        return view('comptable.scolarite.liste-etudiant-scolarite', compact('etudiants', 'anneeAcademique'));
    }

    public function listeProfesseurRecu() {
        $professeurs = Professeur::where('valide', 1)->orderBy('fullname', 'ASC')->get();
        return view('comptable.professeur.liste-professeur-recu', compact('professeurs'));
    }

    public function listeRecu($id) {
        $professeur = Professeur::findOrFail($id);
        $anneeAcademique = getSelectedAnneeAcademique() ?? getLastAnneeAcademique();
        $paiements = $professeur->paiementProfesseurs()->where(['annee_academique_id' => $anneeAcademique->id])->get();
        // dd($paiements);
        $facultes = Faculte::orderBy('nom', 'asc')->get();
        return view('comptable.professeur.recu-professeur', compact('paiements', 'professeur', 'facultes'));
    }

    public function paiementProfesseurPost(Request $request, $id) {
        $request->validate([
            'date_paiement' => 'required|date',
            'faculte' => 'required|integer',
            'entite' => 'required|string',
            'mode_paiement' => 'required|string',
            'montant_paiement' => 'required|numeric',
            'note' => 'nullable|string',
        ]);

        $professeur = Professeur::findOrFail($id);
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();

        $lastPaiement = PaiementProfesseur::all()->last();
        $numeroRecu = !is_null($lastPaiement) ? ($lastPaiement->numero_recu + 1) : 1;
        if($request->entite == 'UA ABIDJAN') {
            $ville = 'ABIDJAN';
        }
        else if($request->entite == 'UA BASSAM') {
            $ville = 'BASSAM';
        }
        else if($request->entite == 'UA BOUAKE') {
            $ville = 'BOUAKE';
        }
        else {
            $ville = 'SAN-PEDRO';
        }

        PaiementProfesseur::create([
            'objet' => 'Reçu de paiement',
            'entite' => $request->entite,
            'ville' => $ville,
            'mode_paiement' => $request->mode_paiement,
            'note' => $request->note ?? 'RAS',
            'date_paiement' => $request->date_paiement,
            'numero_recu' => $numeroRecu,
            'montant_paiement' => $request->montant_paiement,
            'professeur_id' => $professeur->id,
            'personnel_id' => Auth::id(),
            'faculte_id' => $request->faculte,
            'annee_academique_id' => $anneeAcademique->id,
        ]);

        flashy('Paiement enrégistré !');
        return redirect()->back();
    }

    public function professeurRecuPdf($id) {
        $paiement = PaiementProfesseur::findOrFail($id);
        $recu = PDF::loadView('comptable.professeur.recu-professeur-pdf', compact('paiement'));
        return $recu->stream();
        // return view('comptable.professeur.recu-professeur-pdf');
    }

    public function etudiantScolarite($id) {
        $etudiant = User::findOrFail($id);
        $anneeAcademique = getSelectedAnneeAcademique() ?? getLastAnneeAcademique();
        $scolarites = [];

        $inscription = $etudiant->inscriptions
            ->where('annee_academique_id', $anneeAcademique->id)
            ->last();
        
        array_push($scolarites, [
            'libelle' => 'inscription',
            'nom_banque' => $inscription->nom_banque,
            'numero_bordereau' => $inscription->numero_bordereau,
            'numero_recu' => $inscription->numero_recu,
            'scolarite' => '',
            'versement' => $inscription->frais_inscription,
            'reste' => '',
            'date' => explode('-' ,$inscription->date_versement)[2] . '/' . explode('-' ,$inscription->date_versement)[1] . '/' . explode('-' ,$inscription->date_versement)[0],
            'scolarite_id' => $inscription->id,
        ]);

        foreach ($etudiant->scolarites->where('annee_academique_id', $anneeAcademique->id)->sortBy('created_at') as $scolarite) {
            $data = [
                'libelle' => 'scolarite',
                'nom_banque' => $scolarite->nom_banque,
                'numero_bordereau' => $scolarite->numero_bordereau,
                'numero_recu' => $scolarite->numero_recu,
                'scolarite' => $scolarite->montant_scolarite,
                'versement' => $scolarite->versement,
                'reste' => $scolarite->reste,
                'date' => explode('-' ,$scolarite->date_versement)[2] . '/' . explode('-' ,$scolarite->date_versement)[1] . '/' . explode('-' ,$scolarite->date_versement)[0],
                'scolarite_id' => $scolarite->id,
            ];
            array_push($scolarites, $data);
        }
        return view('comptable.scolarite.scolarite', compact('etudiant', 'scolarites'));
    }

    public function postScolarite(Request $request, $id) {
        $this->validate($request, [
            'libelle' => 'required|string',
            'nom_banque' => 'required|string',
            'numero_bordereau' => 'required|string|unique:scolarites,numero_bordereau',
            'date_versement' => 'required|date',
            'numero_recu_scolarite' => 'required|string|unique:scolarites,numero_recu',
            'montant_frais_scolarite' => 'required|numeric',
        ]);

        $etudiant = User::findOrFail($id);
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        
        if($request->libelle == 'scolarite') {
            $scolarite = $etudiant->inscriptions->where('annee_academique_id', $anneeAcademique->id)->last()->net_payer;
            $payee = $etudiant->scolarites->sum('versement') + $request->montant_frais_scolarite;
            $reste = $scolarite - $payee;
    
            $lastScolarite = Scolarite::all()->last();
            if (!is_null($lastScolarite)) {
                Scolarite::create([
                    'nom_banque' => $request->nom_banque,
                    'numero_bordereau' => $request->numero_bordereau,
                    'code_caisse' => $lastScolarite->code_caisse + 1,
                    'numero_recu' => $request->numero_recu_scolarite,
                    'date_versement' => $request->date_versement,
                    'montant_scolarite' => $scolarite,
                    'payee' => $payee,
                    'net_payer' => $scolarite,
                    'versement'=> $request->montant_frais_scolarite,
                    'reste' => $reste,
                    'user_id' => $etudiant->id,
                    'annee_academique_id' => $anneeAcademique->id,
                ]);
            }
            else {
                Scolarite::create([
                    'nom_banque' => $request->nom_banque,
                    'numero_bordereau' => $request->numero_bordereau,
                    'code_caisse' => 1,
                    'numero_recu' => $request->numero_recu_scolarite,
                    'date_versement' => $request->date_versement,
                    'montant_scolarite' => $scolarite,
                    'payee' => $payee,
                    'net_payer' => $scolarite,
                    'versement'=> $request->montant_frais_scolarite,
                    'reste' => $reste,
                    'user_id' => $etudiant->id,
                    'annee_academique_id' => $anneeAcademique->id,
                ]);
            }
        }
        else {
            $etudiant->inscriptions
                ->where('annee_academique_id', $anneeAcademique->id)
                ->last()
                ->update([
                    'nom_banque' => $request->nom_banque,
                    'numero_bordereau' => $request->numero_bordereau,
                    'numero_recu' => $request->numero_recu_scolarite,
                    'date_versement' => $request->date_versement,
                    'frais_inscription'=> $request->montant_frais_scolarite,
                ]);
        }

        flashy('Paiement enrégistré !');
        return redirect()->back();
    }

    public function recuScolarite(Request $request) {
        $request->validate([
            'id' => 'required|integer',
            'libelle' => 'required|in:scolarite,inscription'
        ]);
        $anneeAcademique = getSelectedAnneeAcademique() ?? getLastAnneeAcademique();
        $scolarite = $request->libelle == 'scolarite' ? Scolarite::findOrFail($request->id) : Inscription::findOrFail($request->id);
        $recu = PDF::loadView('comptable.scolarite.recu-scolarite', compact('scolarite', 'anneeAcademique'));
        return $recu->stream();
        // return view('comptable.scolarite.recu-scolarite', compact('scolarite', 'anneeAcademique'));
    }

    public function listeEtudiants() {
        $anneeAcademique = getSelectedAnneeAcademique() ?? getLastAnneeAcademique();
        $etudiants = User::whereHas('inscriptions', function(Builder $query) use ($anneeAcademique) {
            $query->where('annee_academique_id', $anneeAcademique->id)->where('valide', 1);
        })->get();
        return view('comptable.liste-etudiant', compact('etudiants', 'anneeAcademique'));
    }

    public function echeancier($id) {
        $etudiant = User::findOrFail($id);
        $anneeAcademique = getSelectedAnneeAcademique() ?? getLastAnneeAcademique();

        return view('comptable.echeancier.echeancier', compact('etudiant', 'anneeAcademique'));
    }

    public function valideEcheancier(Request $request, $id) {
        $echeancier = Echeancier::findOrFail($id);
        $echeancier->update([
            'statut' => 'validé',
        ]);

        flashy()->message('Echéancier validé !');
        return redirect()->back();
    }

    public function refusEcheancier(Request $request, $id) {
        $request->validate([
            'motif' => 'required|string',
        ]);

        $echeancier = Echeancier::findOrFail($id);
        $echeancier->update([
            'statut' => 'non validé',
            'observation' => $request->motif,
        ]);

        flashy()->message('Echéancier réfusé !');
        return redirect()->back();
    }

    public function modifierEcheancier($id) {

        $etudiant = User::findOrFail($id);
        return view('comptable.echeancier.edit-echeancier', compact('etudiant'));
    }

    public function postModifierEcheancier(Request $request, $id) {
        $this->validate($request, [
            'date_1' => 'required|date',
            'versement_1' => 'required|integer',
            'date_2' => 'required|date',
            'versement_2' => 'required|integer',
            'date_3' => 'required|date',
            'versement_3' => 'required|integer',
            'date_4' => 'required|date',
            'versement_4' => 'required|integer',
            'date_5' => 'required|date',
            'versement_5' => 'required|integer',
            'date_6' => 'required|date',
            'versement_6' => 'required|integer',
            'date_7' => 'required|date',
            'versement_7' => 'required|integer',
        ]);

        $etudiant = User::findOrFail($id);
        $echeancier = Echeancier::findOrFail($etudiant->echeancier->id);
        $echeancier->update($request->all());

        flashy()->message('Echéancier modifié !');
        return redirect()->route('admin.etudiant-echeancier', $etudiant->id);
    }

    public function vacation() {
        $vacationData = new ProfesseurDataService();
        $vacationDatas = $vacationData->vacationData()[0];
        $anneeAcademique = $vacationData->vacationData()[1];

        return view('comptable.vacation', compact('vacationDatas', 'anneeAcademique'));
    }

    public function professeurs() {
        $professeurs = Professeur::where('valide', 1)->orderBy('fullname', 'ASC')->get();
        return view('comptable.professeur.liste-professeur', compact('professeurs'));
    }

    public function detailsProfesseur($id) {
        $professeur = Professeur::findOrFail($id);
        return view('comptable.professeur.details-professeur', compact('professeur'));
    }

    public function tauxHoraireProfesseur(Request $request, $id) {
        $this->validate($request, [
            'taux_horaire_bts' => 'required|integer',
            'taux_horaire_licence' => 'required|integer',
            'taux_horaire_master' => 'required|integer',
        ]);

        $professeur = Professeur::findOrFail($id);
        $professeur->update([
            'taux_horaire_bts' => $request->taux_horaire_bts,
            'taux_horaire_licence' => $request->taux_horaire_licence,
            'taux_horaire_master' => $request->taux_horaire_master,
        ]);

        flashy()->success('Modification effectuée avec succès');
        return redirect()->back();
    }
}

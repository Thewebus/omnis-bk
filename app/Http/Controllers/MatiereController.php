<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Faculte;
use App\Models\Matiere;
use App\Models\Professeur;
use Illuminate\Http\Request;
use App\Models\AnneeAcademique;
use App\Models\ClasseProfesseur;
use App\Models\MatiereProfesseur;
use App\Models\UniteEnseignement;
// use App\Imports\MatiereImport;

class MatiereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matieres = Matiere::orderBy('nom', 'ASC')->get();
        return view('informatique.matiere.index', compact('matieres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $uniteEnseignements = UniteEnseignement::orderBy('nom', 'ASC')->get();
        $classes = Classe::orderBy('nom', 'ASC')->get();
        $professeurs = Professeur::where('valide', 1)->orderBy('fullname', 'ASC')->get();
        return view('informatique.matiere.create', compact('uniteEnseignements', 'classes', 'professeurs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'unite_enseignement' => 'required|integer',
            'classe' => 'required|integer',
            'professeur' => 'required|integer',
            'numero_ordre' => 'required|integer',
            'nom' => 'required|string',
            'semestre' => 'required|in:1,2',
            'coefficient' => 'required|integer',
            'credit' => 'required|integer',
            'volume_horaire' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $matiere = Matiere::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'volume_horaire' => $request->volume_horaire,
            'numero_ordre' => $request->numero_ordre,
            'coefficient' => $request->coefficient,
            'credit' => $request->credit,
            'semestre' => $request->semestre,
            'classe_id' => $request->classe,
            'unite_enseignement_id' => $request->unite_enseignement,
        ]);
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();

        MatiereProfesseur::create([
            'volume_horaire' => $request->volume_horaire,
            'matiere_id' => $matiere->id,
            'professeur_id' => $request->professeur,
            'classe_id' => $request->classe,
            'annee_academique_id' => $anneeAcademique->id,
        ]);

        $classeProf = ClasseProfesseur::where('annee_academique_id', $anneeAcademique->id)->where('classe_id', $request->classe)->where('professeur_id', $request->professeur)->count();
        if (!$classeProf) {
            ClasseProfesseur::create([
                'classe_id' => $request->classe,
                'professeur_id' => $request->professeur,
                'annee_academique_id' => $anneeAcademique->id,
            ]);
        }
        
        flashy()->success('Element enregistré avec succès');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $uniteEnseignements = UniteEnseignement::orderBy('nom', 'ASC')->get();
        $classes = Classe::orderBy('nom', 'ASC')->get();
        $matiere = Matiere::findOrFail($id);
        $profs = Professeur::where('valide', 1)->orderBy('fullname', 'ASC')->get();
        $matierePro = MatiereProfesseur::with('professeur')
            ->where('matiere_id', $matiere->id)
            ->where('classe_id', $matiere->classe->id)
            ->where('annee_academique_id', $anneeAcademique->id)
            ->first();
        $professeur = $matierePro ? $matierePro->professeur : '';
        return view('informatique.matiere.edit', compact('matiere', 'uniteEnseignements', 'classes', 'profs', 'professeur'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'unite_enseignement' => 'required|integer',
            'classe' => 'required|integer',
            'professeur' => 'required|integer',
            'numero_ordre' => 'required|integer',
            'nom' => 'required|string',
            'semestre' => 'required|in:1,2',
            'coefficient' => 'required|integer',
            'credit' => 'required|integer',
            'volume_horaire' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $classe = Classe::findOrFail($request->classe);
        $matiere = Matiere::findOrFail($id);
        $matiere->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'volume_horaire' => $request->volume_horaire,
            'numero_ordre' => $request->numero_ordre,
            'coefficient' => $request->coefficient,
            'credit' => $request->credit,
            'semestre' => $request->semestre,
            'classe_id' => $classe->id,
            'unite_enseignement_id' => $request->unite_enseignement,
        ]);

        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();

        $professeur = Professeur::findOrFail($request->professeur);
        $matiereProfesseur = MatiereProfesseur::where('annee_academique_id', $anneeAcademique->id)->where('matiere_id', $matiere->id)->first();

        if($matiereProfesseur) {
            if ($professeur->id !== $matiereProfesseur->professeur_id) {
                
                // On verifie si le professeur enseigne dans d'autres matière de la classe
                $matiereProfesseurVerif = MatiereProfesseur::where('annee_academique_id', $anneeAcademique->id)->where('classe_id', $matiere->classe->id)->where('professeur_id', $matiereProfesseur->professeur_id)->count();
    
                // Si le professeur ne prend qu'une matière de la classe
                if($matiereProfesseurVerif == 1) {
                    $classeProf = ClasseProfesseur::where('annee_academique_id', $anneeAcademique->id)->where('classe_id', $matiere->classe->id)->where('professeur_id', $matiereProfesseur->professeur_id)->first();
                    $classeProf->forceDelete();
    
                    $newClasseProf = ClasseProfesseur::where('annee_academique_id', $anneeAcademique->id)->where('classe_id', $matiere->classe->id)->where('professeur_id', $professeur->id)->count();
                    if (!$newClasseProf) {
                        ClasseProfesseur::create([
                            'classe_id' => $matiere->classe->id,
                            'professeur_id' => $professeur->id,
                            'annee_academique_id' => $anneeAcademique->id,
                        ]);
                    }
                }
                
                $matiereProfesseur->update([
                    'volume_horaire' => $request->volume_horaire,
                    'matiere_id' => $matiere->id,
                    'professeur_id' => $request->professeur,
                    'classe_id' => $classe->id,
                    'annee_academique_id' => $anneeAcademique->id,
                ]); 
            }
        }
        else {
            MatiereProfesseur::create([
                'volume_horaire' => $request->volume_horaire,
                'matiere_id' => $matiere->id,
                'professeur_id' => $professeur->id,
                'classe_id' => $classe->id,
                'annee_academique_id' => $anneeAcademique->id,
            ]);
    
            $classeProf = ClasseProfesseur::where('annee_academique_id', $anneeAcademique->id)->where('classe_id', $request->classe)->where('professeur_id', $request->professeur)->count();
            if (!$classeProf) {
                ClasseProfesseur::create([
                    'classe_id' => $classe->id,
                    'professeur_id' => $professeur->id,
                    'annee_academique_id' => $anneeAcademique->id,
                ]);
            }
        }


        flashy()->success('Element enregistré avec succès');
        return redirect()->back();
    }

    /**
     * Import New Matiere
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
    */

    public function importMatiere() {
        return view('informatique.matiere.import-matiere');
    }


    // public function StoreimportedMatiere(Request $request) {
    //     $this->validate($request, [
    //         'filiere' => 'required|integer',
    //         'niveau' => 'required|integer',
    //     ]);
    //     dd($request->file());
    //     Excel::import(new MatiereImport, $request->file);
    //     dd('Courses imported !!!');
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $matiere = Matiere::findOrFail($id);
        $matiere->delete();

        flashy()->success('Element supprimé avec succès');
        return redirect()->back();
    }
}

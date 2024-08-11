<?php

namespace App\Http\Controllers;

use App\Models\AnneeAcademique;
use App\Models\Classe;
use App\Models\Cours;
use App\Models\MatiereProfesseur;
use App\Models\Salle;
use App\Rules\CoursTimeAvailabilityRule;
use App\Services\ScheduleService;
use Illuminate\Http\Request;
class ScolariteScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Classe::orderBy('nom', 'ASC')->get();
        return view('personnels.schedule.index', compact('classes'));
    }

    public function indexCours($id) {
        $jours = Cours::JOURS;
        $classe = Classe::findOrFail($id);
        $salles = Salle::orderBy('nom', 'ASC')->get();

        return view('personnels.schedule.index-cours', compact('classe', 'salles', 'jours'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $classe = Classe::findOrFail($id);
        $salles = Salle::orderBy('nom', 'ASC')->get();
        return view('personnels.schedule.create', compact('classe', 'salles'));
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
            'jour'    => ['required', 'integer', 'min:1', 'max:7'],
            'matiere' => ['required', 'integer'],
            'salle' => ['required', 'integer'],
            'classe' => ['required', 'integer'],
            'heure_debut' => ['required', new CoursTimeAvailabilityRule(), 'date_format:H:i'],
            'heure_fin'   => ['required', 'after:heure_debut', 'date_format:H:i'],
        ]);

        $classe = Classe::findOrFail($request->classe);
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $matiereProfesseur = MatiereProfesseur::with('professeur')->where('annee_academique_id', $anneeAcademique->id)
            ->where('matiere_id', $request->matiere)->where('classe_id', $classe->id)->first();

        if (is_null($matiereProfesseur)) {
            flashy()->error('Cette matière n\'est pas affectée à un professseur !');
            return redirect()->route('admin.scolarite.emploi-du-temps.maquette', $classe->id);
        }

        Cours::create([
            'jour'    => $request->jour,
            'heure_debut' => $request->heure_debut,
            'heure_fin' => $request->heure_fin,
            'classe_id' => $classe->id,
            'matiere_id' => $request->matiere,
            'professeur_id' => $matiereProfesseur->professeur->id,
            'salle_id' => $request->salle,
            'annee_academique_id' => $anneeAcademique->id,
        ]);

        flashy()->message('Cours enregistré !');
        return redirect()->route('admin.scolarite.emploi-du-temps.maquette', $classe->id);
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
        //
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
            'jour'    => ['required', 'integer', 'min:1', 'max:7'],
            'matiere' => ['required', 'integer'],
            'salle' => ['required', 'integer'],
            'classe' => ['required', 'integer'],
            'heure_debut' => ['required', new CoursTimeAvailabilityRule(), 'date_format:H:i'],
            'heure_fin'   => ['required', 'after:heure_debut', 'date_format:H:i'],
        ]);

        $cours = Cours::findOrFail($id);

        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $matiereProfesseur = MatiereProfesseur::with('professeur')->where('annee_academique_id', $anneeAcademique->id)
            ->where('matiere_id', $request->matiere)->where('classe_id', $request->classe)->first();

        if (is_null($matiereProfesseur)) {
            flashy()->error('Cette matière n\'est pas affectée à un professseur !');
            return redirect()->route('admin.scolarite.emploi-du-temps.maquette', $request->classe);
        }

        $cours->update([
            'jour' => $request->jour,
            'heure_debut' => $request->heure_debut,
            'heure_fin' => $request->heure_fin,
            'classe_id' => $request->classe,
            'matiere_id' => $request->matiere,
            'professeur_id' => $matiereProfesseur->professeur->id,
            'salle_id' => $request->salle,
            'annee_academique_id' => $anneeAcademique->id,
        ]);

        flashy()->message('Modification effecuée !');
        return redirect()->route('admin.scolarite.emploi-du-temps.maquette', $request->classe);
    }

    public function maquette(ScheduleService $scheduleService, $id) {
        $jours = Cours::JOURS;
        $classe = Classe::findOrFail($id);
        $donneesCalendrier = $scheduleService->genererDonneesCalendrier($jours, $id);

        return view('personnels.schedule.maquette', compact('jours', 'donneesCalendrier', 'classe'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cours = Cours::findOrFail($id);
        $cours->delete();

        flashy()->warning('Suppression effectuée');
        return redirect()->back();
    }
}

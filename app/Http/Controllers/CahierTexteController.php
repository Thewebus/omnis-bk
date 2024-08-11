<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\CahierTexte;
use Illuminate\Http\Request;
use App\Models\AnneeAcademique;
use App\Models\MatiereProfesseur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CahierTexteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) {
        $classe = Classe::findOrFail($id);
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $cahierTextes = CahierTexte::where('annee_academique_id', $anneeAcademique->id)->where('classe_id', $id)->where('professeur_id', Auth::id())->get();
        
        return view('professeur.cahier-text.index', compact('classe', 'cahierTextes'));
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $classe = Classe::findOrFail($id);
        return view('professeur.cahier-text.create', compact('classe'));
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
            'classe' => 'required|integer',
            'matiere' => 'required|integer',
            'date' => 'required|date',
            'duree' => 'required|integer',
            'contenu' => 'required|string',
            'bibliographie' => 'nullable|string',
        ]);

        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();

        CahierTexte::create([
            'date' => $request->date,
            'duree' => $request->duree,
            'contenu' => $request->contenu,
            'bibliographie' => $request->bibliographie,
            'classe_id' => $request->classe,
            'matiere_id' => $request->matiere,
            'professeur_id' => Auth::id(),
            'annee_academique_id' => $anneeAcademique->id,
        ]);

        $matiereProfesseur = MatiereProfesseur::where('annee_academique_id', $anneeAcademique->id)
            ->where('professeur_id', Auth::id())
            ->where('matiere_id', $request->matiere)
            ->first();
        
        $matiereProfesseur->increment('progression', $request->duree);

        flashy()->message('Enrégistrement effectué');
        return redirect()->route('prof.cahier-texte-index', $request->classe);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

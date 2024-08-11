<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Echeancier;
use Illuminate\Http\Request;
use App\Models\AnneeAcademique;
use Illuminate\Support\Facades\Auth;

class EcheancierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $echeancier = Echeancier::where('annee_academique_id', $anneeAcademique->id)->where('user_id', Auth::id())->first();
        return view('etudiant.echeancier.index', compact('echeancier'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('etudiant.echeancier.create');
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

        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();

        Echeancier::create([
            'versement_1' => $request->versement_1,
            'date_1' => $request->date_1,
            'versement_2' => $request->versement_2,
            'date_2' => $request->date_2,
            'versement_3' => $request->versement_3,
            'date_3' => $request->date_3,
            'versement_4' => $request->versement_4,
            'date_4' => $request->date_4,
            'versement_5' => $request->versement_5,
            'date_5' => $request->date_5,
            'versement_6' => $request->versement_6,
            'date_6' => $request->date_6,
            'versement_7' => $request->versement_7,
            'date_7' => $request->date_7,
            'user_id' => Auth::id(),
            'annee_academique_id' => $anneeAcademique->id,
        ]);

        flashy()->message('Echéancier enrégistré !');
        return redirect()->route('user.echeancier.index');
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
        $echeancier = Echeancier::findOrFail($id);
        return view('etudiant.echeancier.edit', compact('echeancier'));
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

        $echeancier = Echeancier::findOrFail($id);
        $echeancier->update([
            'versement_1' => $request->versement_1,
            'date_1' => $request->date_1,
            'versement_2' => $request->versement_2,
            'date_2' => $request->date_2,
            'versement_3' => $request->versement_3,
            'date_3' => $request->date_3,
            'versement_4' => $request->versement_4,
            'date_4' => $request->date_4,
            'versement_5' => $request->versement_5,
            'date_5' => $request->date_5,
            'versement_6' => $request->versement_6,
            'date_6' => $request->date_6,
            'versement_7' => $request->versement_7,
            'date_7' => $request->date_7,
        ]);

        flashy()->message('Echéancier enrégistré !');
        return redirect()->route('user.echeancier.index');
    }


    public function echeancierDownload() {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $echeancier = Echeancier::where('annee_academique_id', $anneeAcademique->id)->where('user_id', Auth::id())->first();
        $echeancierPDF = PDF::loadView('etudiant.echeancier.echeancier-pdf', compact('echeancier'));
        return $echeancierPDF->stream();
        // return view('etudiant.echeancier.echeancier-pdf', compact('echeancier'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $echeancier = Echeancier::findOrFail($id);
        $echeancier->delete();

        flashy()->message('Suppression effectuée !');
        return redirect()->route('user.echeancier.index');
        
    }
}

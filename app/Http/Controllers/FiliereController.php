<?php

namespace App\Http\Controllers;

use App\Models\Faculte;
use App\Models\Filiere;
use App\Models\Institut;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filieres = Filiere::orderBy('nom', 'ASC')->get();
        return view('informatique.filiere.index', compact('filieres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $facultes = Faculte::orderBy('nom', 'ASC')->get();
        return view('informatique.filiere.create', compact('facultes'));
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
            'faculte' => 'required|integer',
            'nom_filiere' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $filiere = Filiere::create([
            'nom' => $request->nom_filiere,
            'description' => $request->description,
            'faculte_id' => $request->faculte,
        ]);

        flashy()->success('Element enregistré avec succès');
        return redirect()->route('admin.filiere.edit', $filiere->id);
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
        $filiere = Filiere::findOrFail($id);
        $facultes = Faculte::orderBy('nom', 'ASC')->get();
        return view('informatique.filiere.edit', compact('filiere', 'facultes'));
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
            'faculte' => 'required|integer',
            'nom_filiere' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $filiere = Filiere::findOrFail($id);
        $filiere->update([
            'nom' => $request->nom_filiere,
            'description' => $request->description,
            'faculte_id' => $request->faculte,
        ]);

        flashy()->success('Modification éffectuée avec succès');
        return redirect()->route('admin.filiere.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $filiere = Filiere::findOrFail($id);
        $filiere->delete();

        flashy()->warning('Suppression effectuée');
        return redirect()->back();
    }
}

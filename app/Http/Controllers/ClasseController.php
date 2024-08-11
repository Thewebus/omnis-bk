<?php

namespace App\Http\Controllers;

use App\Models\AnneeAcademique;
use App\Models\Classe;
use App\Models\Faculte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $classes = Classe::orderBy('nom', 'ASC')->get();
        Auth::user()->type == 'informaticien' ? $master = 'informatique' : $master = 'personnel';

        return view('informatique.classe.index', compact('classes', 'master'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $facultes = Faculte::orderBy('nom', 'ASC')->get();
        Auth::user()->type == 'informaticien' ? $master = 'informatique' : $master = 'personnel';
        
        return view('informatique.classe.create', compact('facultes', 'master'));
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
            'niveau' => 'required|integer',
            'nom' => 'required|string',
            'code' => 'required|unique:classes,code',
            'description' => 'nullable|string',
        ]);

        Classe::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'code' => $request->code,
            'niveau_faculte_id' => $request->niveau,
        ]);

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
        $classe = Classe::findOrFail($id);
        $facultes = Faculte::orderBy('nom', 'ASC')->get();
        Auth::user()->type == 'informaticien' ? $master = 'informatique' : $master = 'personnel';

        return view('informatique.classe.edit', compact('classe', 'facultes', 'master'));
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
        $classe = Classe::findOrFail($id);

        $this->validate($request, [
            'faculte' => 'required|integer',
            'niveau' => 'required|integer',
            'nom' => 'required|string',
            'code' => 'required|unique:classes,code,' . $classe->id,
            'description' => 'nullable|string',
        ]);

        $classe->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'code' => $request->code,
            'niveau_faculte_id' => $request->niveau,
        ]);
        Auth::user()->type == 'informaticien' ? $master = 'informatique' : $master = 'personnel';

        flashy()->success('Modification enregistrée avec succès');
        return redirect()->route('admin.classe.index')->with('master', $master);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $classe = Classe::findOrFail($id);
        $classe->delete();

        flashy()->warning('Suppression effectuée');
        return redirect()->back();
    }

    public function corbeilleClasses() {
        $classes = Classe::orderBy('nom', 'ASC')->onlyTrashed()->get();
        Auth::user()->type == 'informaticien' ? $master = 'informatique' : $master = 'personnel';

        return view('informatique.classe.corbeille-classe', compact('classes', 'master'));
    }

    public function postCorbeilleClasse($id) {
        Classe::withTrashed()->where('id',$id)->forceDelete();
        Auth::user()->type == 'informaticien' ? $master = 'informatique' : $master = 'personnel';
        flashy()->message('Classe définitivement supprimé !');

        return redirect()->back();
    }

    public function restorationClasse($id) {
        Classe::withTrashed()->find($id)->restore();
        Auth::user()->type == 'informaticien' ? $master = 'informatique' : $master = 'personnel';
        flashy()->message('Restoration effectuée!');

        return redirect()->back();
    }

}

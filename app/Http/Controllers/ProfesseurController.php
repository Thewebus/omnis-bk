<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Professeur;
use Illuminate\Http\Request;

class ProfesseurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profs = Professeur::orderBy('fullname', 'ASC')->get();
        return view('informatique.professeur.index', compact('profs'));
    }

    public function indexDownload() {
        $profs = Professeur::orderBy('fullname', 'ASC')->get();
        $liste = PDF::loadView('informatique.professeur.liste-professeurs-pdf', compact('profs'));
        return $liste->stream();
        // return view('informatique.professeur.liste-professeurs-pdf', compact('profs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('informatique.professeur.create');
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
            'fullname' => 'required|string',
            'email' => 'required|email|unique:professeurs',
        ]);

        Professeur::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'valide' => 1,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        flashy()->success('Enrégistremment effectué !');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Professeur $professeur)
    {
        return view('informatique.professeur.show', compact('professeur'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Professeur $professeur)
    {
        return view('informatique.professeur.edit', compact('professeur'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Professeur $professeur)
    {
        $this->validate($request, [
            'fullname' => 'required|string',
            'email' => 'required|email|unique:professeurs,email,'.$professeur->id,      
        ]);

        $professeur->update([
            'fullname' => $request->fullname,
            'email' => $request->email,
        ]);

        flashy()->success('Modification effectuée avec succès');
        return redirect()->back();
    }

    public function valideEnregistrement($id) {
        $professeur = Professeur::findOrFail($id);
        $professeur->update([
            'valide' => 1,
        ]);
        
        flashy()->success('Professeur validé !');
        return redirect()->back();
    }

    public function refusEnregistrement(Request $request, $id) {
        $this->validate($request, [
            'motif' => 'required|string',
        ]);

        $professeur = Professeur::findOrFail($id);
        $professeur->update([
            'raison' => $request->motif,
        ]);

        flashy()->warning('Dossier réfusé !');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.v
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Professeur $professeur)
    {
        $professeur->delete();

        flashy()->success('Suppression éffectué !');
        return redirect()->back();
    }
}

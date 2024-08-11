<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reclamation;
use Illuminate\Http\Request;
use App\Models\AnneeAcademique;
use Illuminate\Support\Facades\Auth;

class ReclamationController extends Controller
{
        public $anneeAcademique;
    
        public function __construct() {
            // $this->anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
            $this->anneeAcademique = AnneeAcademique::find(1);

        }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reclamations = Reclamation::where('user_id', Auth::id())->get();
        $anneeAcademique = $this->anneeAcademique;
        $reclamation_type = Reclamation::reclamations_type;
        return view('etudiant.reclamations.index', compact('reclamations', 'reclamation_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $etudiant = User::findOrFail(Auth::id());
        $matieres = $etudiant->classe($this->anneeAcademique->id)->matieres;
        $reclamations = Reclamation::reclamations_type;
        return view('etudiant.reclamations.create', compact('matieres', 'reclamations'));
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
            'objet' => 'required|string',
            'matiere' => 'required|integer',
            'reclamations' => 'required',
            'description' => 'required|string'
        ]);

        Reclamation::create([
            'objet' => $request->objet,
            'message' => $request->description,
            'reclamation_type' => $request->reclamations,
            'user_id' => Auth::id(),
            'matiere_id' => $request->matiere,
        ]);

        flashy()->success('Réclamation enregistrée avec succès !');
        return redirect()->route('user.reclamations.index');
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

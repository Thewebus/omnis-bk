<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Matiere;
use Illuminate\Http\Request;
use App\Models\RattrapageNote;

class RattrapageNoteController extends Controller
{

    public function index() {
        $rattrapages = RattrapageNote::join('users', 'rattrapage_notes.user_id', '=', 'users.id')
            ->orderBy('users.fullname', 'asc')
            ->select('rattrapage_notes.*')
            ->get();
        return view('informatique.rattrapage-note.index', compact('rattrapages'));
    }

    public function inscrit() {
        $etudiants = User::orderBy('fullname', 'asc')->get();
        $matieres = Matiere::orderBy('nom', 'ASC')->get();

        return view('informatique.rattrapage-note.inscrit', compact('etudiants', 'matieres'));
    }

    public function storeInscrit(Request $request) {
        $request->validate([
            'etudiant' => 'required|string',
            'note' => 'required|numeric',
            'matiere' => 'required',
        ]);

        $matiere = Matiere::findOrFail($request->matiere);

        RattrapageNote::create([
            'note' => $request->note,
            'user_id' => $request->etudiant,
            'matiere_id' => $matiere->id,
            'classe_id' => $matiere->classe->id,
        ]);

        flashy()->success('Enregistrement éffectué !');
        return redirect()->back();
    }

    public function nonInscrit()
    {
        $matieres = Matiere::orderBy('nom', 'ASC')->get();

        return view('informatique.rattrapage-note.non-inscrit', compact('matieres'));
    }

    public function storeNonInscrit(Request $request)
    {
        $request->validate([
            'nom_prenom' => 'required|string',
            'note' => 'required|numeric',
            'matiere' => 'required',
        ]);

        $etudiant = User::where('fullname', $request->nom_prenom)->first();
        if(!$etudiant) {
            $etudiant = User::create([
                'fullname' => $request->nom_prenom
            ]);
        }

        RattrapageNote::create([
            'note' => $request->note,
            'user_id' => $etudiant->id,
            'matiere_id' => $request->matiere,
            'classe_id' => $request->classe_id,
        ]);

        flashy()->success('Enregistrement éffectué !');
        return redirect()->back();
    }

    public function modifNote($id) {
        $rattrapage = RattrapageNote::findOrFail($id);
        return view('informatique.rattrapage-note.modification', compact('rattrapage'));
    }

    public function postModifNote(Request $request, $id) {
        $this->validate($request, [
            'note' => 'required|numeric',
        ]);

        $rattrapage = RattrapageNote::findOrFail($id);
        $rattrapage->update([
            'note' => $request->note,
        ]);
        
        flashy()->success('Modification éffectuée !');
        return redirect()->route('admin.rattrapage.index');
    }

    public function destroy($id) {
        $rattrapage = RattrapageNote::findOrFail($id);
        $rattrapage->delete();

        flashy()->success('Suppression éffectuée !');
        return back();
    }
}

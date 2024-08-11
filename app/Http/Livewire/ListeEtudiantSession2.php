<?php

namespace App\Http\Livewire;

use App\Models\Note;
use App\Models\User;
use App\Models\Matiere;
use Livewire\Component;
use App\Models\AnneeAcademique;
use App\Services\OtherDataService;
use MercurySeries\Flashy\Flashy;
use PhpParser\Node\Expr\FuncCall;

class ListeEtudiantSession2 extends Component
{
    public $dataBrute;
    public $matiere;
    public $dataNotes;
    public $notes;

    protected $listeners = [
        'listeEtudiantSession2' //=> 'listeEtudiantSession2',
        // 'refreshComponent' => '$refresh'
    ];
    
    protected $rules = [
        'notes.*' => 'required',
    ];

    public function listeEtudiantSession2($matiereId) {
        $this->dataBrute = (new OtherDataService)->notesMatiere($matiereId);
        $this->matiere = $this->dataBrute[1];
        $this->dataNotes = array_filter($this->dataBrute[2], function($element) {
           return $element['moyenne'] < 10 && $element['partiel_session_2'] == 'NONE' ? true : false;
        });

        // $array = [];

        // foreach ($this->dataBrute[2] as $value) {
        //     $array[] = $value['nom_etudiant']->fullname;
        // }

        // dd($this->dataBrute[2]);
    }

    public function postSession2($id) {
        $this->validate();

        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $matiere = Matiere::findOrFail($id);

        if (!is_null($this->notes)) {
            foreach($this->notes as $etudiantId => $noteSession2) {
                $etudiant = User::findOrFail($etudiantId);
                $notes = Note::where('annee_academique_id', $anneeAcademique->id)
                    ->where('classe_id', $matiere->classe->id)
                    ->where('matiere_id', $matiere->id)
                    ->where('user_id', $etudiant->id)->first();

                if(!is_null($notes)) {
                        $notes->update([
                            'partiel_session_2' => $noteSession2,
                        ]);
                }
                else {
                    Note::create([
                        'partiel_session_2' => $noteSession2,
                        'classe_id' => $matiere->classe->id,
                        'matiere_id' => $matiere->id,
                        'user_id' => $etudiant->id,
                        'professeur_id' => $matiere->professeurs->first()->id,
                        'annee_academique_id' => $anneeAcademique->id,
                    ]);
                }
            }
        }

        session()->flash('message', 'Note Session 2 insérées !');
        // $this->refresh();
        // $this->emit('refreshComponent');
        // $this->redirect('#');
    }

    public function render()
    {
        return view('livewire.liste-etudiant-session2');
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Note;
use App\Models\User;
use App\Models\Matiere;
use Livewire\Component;
use App\Models\AnneeAcademique;
use App\Services\OtherDataService;

class ModificationNoteSession2 extends Component
{
    public $dataBrute;
    public $matiere;
    public $dataNotes;
    public $notesSelectionnees;
    public $notes = [];

    protected $listeners = [
        'modificationNoteSession2'
    ];

    public function modificationNoteSession2($matiereId) {
        $this->dataBrute = (new OtherDataService)->notesMatiere($matiereId);
        $this->matiere = $this->dataBrute[1];
        // $this->dataNotes = $this->dataBrute[2];

        $this->dataNotes = array_filter($this->dataBrute[2], function($element) {
            return $element['partiel_session_2'] !== 'NONE' && $element['moyenne'] < 10 ? true : false;
        });
        // dd($this->dataNotes);
    }

    // protected $rules = [
    //     'notes.*' => 'required',
    // ];

    public function postModificationSession2($id) {
        // $this->validate();

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
                    if($notes->partiel_session_2 !== $noteSession2) {
                        $notes->update([
                            'partiel_session_2' => $noteSession2,
                        ]);
                    }
                }
                else {
                    // Note::create([
                    //     'partiel_session_2' => $noteSession2,
                    //     'classe_id' => $matiere->classe->id,
                    //     'matiere_id' => $matiere->id,
                    //     'user_id' => $etudiant->id,
                    //     'professeur_id' => $matiere->professeurs->first()->id,
                    //     'annee_academique_id' => $anneeAcademique->id,
                    // ]);
                    dd('Something gone wrong !!');
                }
            }
        }

        session()->flash('message', 'Modification Note Session 2 insérées !');
        // $this->refresh();
        // $this->emit('refreshComponent');
        // $this->redirect('#');
    }

    public function render()
    {
        return view('livewire.modification-note-session2');
    }
}

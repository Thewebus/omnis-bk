<?php

namespace App\Http\Livewire;

use App\Models\Note;
use App\Models\User;
use App\Models\Classe;
use App\Models\Matiere;
use Livewire\Component;
use App\Models\AnneeAcademique;
use App\Models\UniteEnseignement;
use App\Services\BulletinService;

class DeliberationSession2 extends Component
{
    public $note;
    public $notes;
    public $classe;
    public $matiere;
    public $admis;
    public $ajournes;
    public $pourcentageAdmis;
    public $pourcentageAjournes;
    public $nbrEtudiants;
    public $anneeAcademique;
    public $matieresNotes;
    public $moyenneEu;
    public $ue;

    protected $listeners = ['deliberationSession2'];

    public function deliberationSession2($data) {
        $this->admis = 0;
        $this->ajournes = 0;
        $this->pourcentageAdmis = 0;
        $this->pourcentageAjournes = 0;
        $this->classe = Classe::where('id', $data['classe_id'])->first();
        $this->anneeAcademique = getSelectedAnneeAcademique() ?? getLastAnneeAcademique();
        
        if (count($data) == 2) {
            $this->notes = (new BulletinService)->moyenneUe($data['classe_id'], $data[0]['id'], 2);
            $this->ue = UniteEnseignement::findOrFail($data[0]['id']);
            $matieres = Matiere::where(['classe_id' => $data['classe_id']])
                ->where(['unite_enseignement_id' => $data[0]['id']])
                ->get();
            
            $this->matieresNotes = Note::where('annee_academique_id', $this->anneeAcademique->id)
                ->where('classe_id', $this->classe->id)
                ->whereIn('matiere_id', $matieres->pluck('id'))
                ->get();
            
            $this->nbrEtudiants = $this->matieresNotes
                ->where('partiel_session_2', '>', 10)
                ->unique('user_id')
                ->count();
        } else {
            $this->matiere = $data;
            $this->notes = Note::where('annee_academique_id', $this->anneeAcademique->id)
                ->where('classe_id', $this->classe->id)
                ->where('matiere_id', $this->matiere['id'])
                ->get();
    
            $this->notes = $this->notes->filter(function($item) {
                return !is_null($item->etudiant) && $item->etudiant->classe($this->anneeAcademique->id)->id == $this->classe->id;
            });
    
            $this->notes = $this->notes->filter(function($item) {
                return ($item['partiel_session_1'] < 10 || $item['partiel_session_1'] == "NONE") && $item['moyenne'] < 10;
            });
    
            $this->nbrEtudiants = $this->notes->count();
        }
        
        
    }

    public function statistiques() {
        if(is_numeric($this->note)) {
            $this->admis = $this->notes->where('partiel_session_2', '>=', $this->note)->count();
            $this->ajournes = $this->notes->count() - $this->admis;
            $this->pourcentageAdmis = $this->notes->count() !== 0 ? $this->admis * 100 / $this->notes->count() : 0;
            $this->pourcentageAjournes = 100 - $this->pourcentageAdmis;
        }
        else {
            session()->flash('message', 'Veuillez entrer une note de repêchage !');
        }
    }

    public function save() {
        if(is_numeric($this->note)) {
            if (!is_null($this->ue)) {
                foreach ($this->matieresNotes as $note) {
                    if($note->partiel_session_2 >= $this->note && $note->partiel_session_2 < 10) {
                        $note->update([
                            'partiel_session_2' => 10,
                            'note_repechage_session_2' => $this->note,
                            'status' => 'admis'
                        ]);
                    }
                    else {
                        $note->update([
                            'note_repechage_session_2' => $this->note
                        ]);
                    }
                }
            } else {
                foreach ($this->notes as $note) {
                    if($note->partiel_session_2 >= $this->note && $note->partiel_session_2 < 10) {
                        $note->update([
                            'partiel_session_2' => 10,
                            'note_repechage_session_2' => $this->note,
                            'status' => 'admis'
                        ]);
                    }
                    else {
                        $note->update([
                            'note_repechage_session_2' => $this->note
                        ]);
                    }
                }
            }
            
            session()->flash('success', 'Note enregistrée avec succès !');
        }
        else {
            session()->flash('message', 'Veuillez entrer une note de repêchage !');
        }
    }

    public function render()
    {
        return view('livewire.deliberation-session2');
    }
}

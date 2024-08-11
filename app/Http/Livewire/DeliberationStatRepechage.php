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
use Asantibanez\LivewireCharts\Facades\LivewireCharts;

class DeliberationStatRepechage extends Component
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

    protected $listeners = ['statRepechage'];

    public function statRepechage($data) {
        $this->admis = 0;
        $this->ajournes = 0;
        $this->pourcentageAdmis = 0;
        $this->pourcentageAjournes = 0;
        $this->classe = Classe::where('id', $data['classe_id'])->first();
        $this->nbrEtudiants = $this->classe->etudiants()->count();
        $this->anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();

        if(count($data) == 2) {
            $this->notes = (new BulletinService)->moyenneUe($data['classe_id'], $data[0]['id']);
            $this->ue = UniteEnseignement::findOrFail($data[0]['id']);
            $matieres = Matiere::where(['classe_id' => $data['classe_id']])
                ->where(['unite_enseignement_id' => $data[0]['id']])
                ->get();
            
            $this->matieresNotes = Note::where('annee_academique_id', $this->anneeAcademique->id)
                ->where('classe_id', $this->classe->id)
                ->whereIn('matiere_id', $matieres->pluck('id'))
                ->get();
        }
        else {
            $this->matiere = $data;
            $this->notes = Note::where('annee_academique_id', $this->anneeAcademique->id)
                ->where('classe_id', $this->classe->id)
                ->where('matiere_id', $this->matiere['id'])
                ->get();
        }
    }

    public function statistiques() {
        if(is_numeric($this->note)) {
            $this->admis = $this->notes->where('moyenne', '>=', $this->note)->count();
            $this->ajournes = $this->notes->count() - $this->admis;
            $this->pourcentageAdmis = ($this->admis * 100) / $this->notes->count();
            $this->pourcentageAjournes = 100 - $this->pourcentageAdmis;
        }
        else {
            session()->flash('message', 'Veuillez entrer une note de repêchage !');
        }
    }

    public function save() {
        if(is_numeric($this->note)) {
            if (!is_null($this->ue)) {
                foreach($this->matieresNotes as $note) {
                    if($note->moyenne >= $this->note && $note->moyenne < 10) {
                        $note->update([
                            'moyenne' => 10,
                            'note_repechage' => $this->note,
                            'status' => 'admis',
                        ]);
                    }
                    else {
                        $note->update([
                            'note_repechage' => $this->note
                        ]);
                    }
                }
            } else {
                foreach ($this->notes as $note) {
                    if($note->moyenne >= $this->note && $note->moyenne < 10) {
                        $note->update([
                            'moyenne' => 10,
                            'note_repechage' => $this->note,
                            'status' => 'admis',
                        ]);
                    }
                    else {
                        $note->update([
                            'note_repechage' => $this->note
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
        return view('livewire.deliberation-stat-repechage');
    }
}

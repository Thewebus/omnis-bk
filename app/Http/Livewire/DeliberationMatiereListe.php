<?php

namespace App\Http\Livewire;

use App\Models\Classe;
use App\Models\Matiere;
use Livewire\Component;

class DeliberationMatiereListe extends Component
{
    public $matieres;
    public $classe;
    public $action;
    public $ues;
    public $annee;

    protected $listeners = ['classeSelected'];

    public function classeSelected($classe) {
        $this->classe = Classe::findOrFail($classe['id']) ;
        $this->matieres = Matiere::where('classe_id', $this->classe['id'])->orderBy('nom', 'ASC')->get();
        $this->ues = $this->classe->uniteEnseignements->unique();
        // $this->ues = $this->matieres->groupBy('uniteEnseignement.nom')->toArray();
        // $this->ues = array_unique(array_column($this->classe->uniteEnseignements->toArray(), 'nom'));
        // dd($this->ues, $this->classe->uniteEnseignements->unique());
    }

    public function repechageStat($data) {
        $this->emitTo('deliberation-stat-repechage', 'statRepechage', $data);
    }

    public function noteSession2($data) {
        $this->emitTo('liste-etudiant-session2', 'listeEtudiantSession2', $data);
    }

    public function affichageNoteSession2($matiereId) {
        $this->emitTo('affichage-note-session2', 'affichageNoteSession2', $matiereId);
    }

    public function modificationNoteSession2($matiereId) {
        $this->emitTo('modification-note-session2', 'modificationNoteSession2', $matiereId);
    }

    public function deliberationSession2($matiereId) {
        $this->emitTo('deliberation-session2', 'deliberationSession2', $matiereId);
    }

    public function render()
    {
        return view('livewire.deliberation-matiere-liste');
    }
}

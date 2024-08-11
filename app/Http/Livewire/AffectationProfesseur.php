<?php

namespace App\Http\Livewire;

use App\Models\Classe;
use App\Models\Matiere;
use App\Models\NiveauFaculte;
use Livewire\Component;

class AffectationProfesseur extends Component
{
    public $classes;
    public $classeSelect;
    public $niveau;
    public $matieres;
    
    public $classe;

    public function mount() {
        $this->classes = Classe::orderBy('nom', 'ASC')->get();
    }

    public function updatedClasse($classeId) {
        if(!is_null($classeId)) {
            $this->classeSelect = Classe::findOrfail($classeId);
            $this->niveau = $this->classeSelect->niveauFaculte->id;
            // $this->matieres = NiveauFaculte::findOrFail($this->niveau)->matieres;
            $this->matieres = $this->classeSelect->matieres->sortBy('nom');
        }
    }

    public function render()
    {
        return view('livewire.affectation-professeur');
    }
}

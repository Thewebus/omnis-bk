<?php

namespace App\Http\Livewire;

use App\Models\Faculte;
use App\Models\NiveauFaculte;
use Livewire\Component;

class MatiereNiveau extends Component
{
    public $matiere;
    public $facultes;
    public $niveaux;

    public $faculte = NULL;

    public function mount() {
        $this->facultes = Faculte::orderBy('nom')->get();
        $this->niveaux = collect();
    }

    public function updatedFiliere($faculte) {
        if(!is_null($faculte)) {
            $this->niveaux = NiveauFaculte::where('faculte_id', $faculte)->get();
        }
    }
    
    public function render()
    {
        return view('livewire.matiere-niveau');
    }
}

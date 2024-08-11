<?php

namespace App\Http\Livewire;

use App\Models\Faculte;
use Livewire\Component;
use App\Models\NiveauFaculte;

class ClasseFiliereNiveau extends Component
{
    public $classe;
    public $facultes;
    public $niveaux;

    public $faculte = NULL;

    public function mount() {
        $this->facultes = Faculte::orderBy('nom')->get();
        $this->niveaux = collect();
    }

    public function updatedFaculte($faculte) {
        if(!is_null($faculte)) {
            $this->niveaux = NiveauFaculte::where('faculte_id', $faculte)->get();
        }
    }

    public function render()
    {
        return view('livewire.classe-filiere-niveau');
    }
}

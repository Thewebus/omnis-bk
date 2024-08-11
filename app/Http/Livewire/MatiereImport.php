<?php

namespace App\Http\Livewire;

use App\Models\Filiere;
use Livewire\Component;
use App\Models\NiveauFiliere;

class MatiereImport extends Component
{
    public $filieres;
    public $niveaux;

    public $filiere = NULL;

    public function mount() {
        $this->filieres = Filiere::orderBy('nom')->get();
        $this->niveaux = collect();
    }

    public function updatedFiliere($filiere) {
        if(!is_null($filiere)) {
            $this->niveaux = NiveauFiliere::where('filiere_id', $filiere)->get();
        }
    }
    
    public function render()
    {
        return view('livewire.matiere-import');
    }
}

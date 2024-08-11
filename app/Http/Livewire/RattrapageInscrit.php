<?php

namespace App\Http\Livewire;

use App\Models\Matiere;
use App\Models\User;
use Livewire\Component;

class RattrapageInscrit extends Component
{
    public $etudiant;
    public $matieres = [];
    public $matiere;
    public $note;

    public function render()
    {
        $etudiants = User::whereNotNull('classe_id')->orderBy('fullname', 'ASC')->get();
        return view('livewire.rattrapage-inscrit', compact('etudiants'));
    }

    public function updatedEtudiant($value)
    {
        $etudiant = User::findOrFail($value);
        // dd($etudiant->classe_id);
        $this->matieres = Matiere::where('classe_id', $etudiant->classe_id)->get();
    }

    // public function store()
    // {
    //     $this->validate([
    //         'etudiantId' => 'required',
    //         'matiere' => 'required',
    //         'note' => 'required',
    //     ]);

    //     Rattrapage::create([
    //         'etudiant_id' => $this->etudiantId,
    //         'matiere_id' => $this->matiereId,
    //         'note' => $this->note,
    //     ]);

    //     session()->flash('success', 'Note de rattrapage enregistrée avec succès');
    //     $this->reset();
    // }
}

<?php

namespace App\Http\Livewire;

use App\Models\Classe;
use Livewire\Component;

class DeliberationClasseListe extends Component
{
    public $classes;
    
    public function mount() {
        $this->classes = Classe::orderBy('nom', 'DESC')->get();
    }

    public function classeSelected($classe) {
        $this->emitTo('deliberation-matiere-liste','classeSelected', $classe);
    }

    public function render()
    {
        return view('livewire.deliberation-classe-liste');
    }
}

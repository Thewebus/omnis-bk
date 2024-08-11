<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\OtherDataService;

class AffichageNoteSession2 extends Component
{
    public $dataBrute;
    public $matiere;
    public $dataNotes;
    public $notesSelectionnees;

    protected $listeners = [
        'affichageNoteSession2',
    ];

    public function affichageNoteSession2($matiereId) {
        $this->dataBrute = (new OtherDataService)->notesMatiere($matiereId);
        $this->matiere = $this->dataBrute[1];
        $this->dataNotes = array_filter($this->dataBrute[2], function($element) {
            return ($element['partiel_session_1'] < 10 || $element['partiel_session_1'] == "NONE") && $element['moyenne'] < 10 ? true : false;
        });
        // dd($this->dataNotes, $this->dataBrute);
    }

    public function render()
    {
        return view('livewire.affichage-note-session2');
    }
}

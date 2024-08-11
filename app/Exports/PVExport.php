<?php

namespace App\Exports;

use App\Models\Classe;
use App\Models\AnneeAcademique;
use App\Services\BulletinService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PVExport implements FromView
{
    public $pvClasse;
    public $entetes;
    public $entete4;
    public $dataAllEtudiants;
    public $classe;
    public $semestre;
    public $session;
    public $anneeAcademique;

    public function __construct($id, $semestre, $session)
    {
        $this->anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        $this->pvClasse = $this->anneeAcademique->id == 1 ? (new BulletinService())->pvOld($id, $semestre, $session) : (new BulletinService())->pv($id, $semestre, $session);
        $this->entetes = $this->pvClasse[0];
        $this->dataAllEtudiants = $this->pvClasse[1];
        $this->entete4 = $this->anneeAcademique->id == 1 ? $this->pvClasse[2] : '';
        $this->classe = Classe::findOrFail($id);
        $this->semestre = $semestre;
        $this->session = $session;
    }

    /**
    * @return \Illuminate\Support\Collection
    */

    public function view(): View
    {
        return view('informatique.pv.pv-pdf', [
            'entetes' => $this->entetes,
            'dataAllEtudiants' => $this->dataAllEtudiants,
            'classe' => $this->classe,
            'semestre' => $this->semestre,
            'session' => $this->session,
            'anneeAcademique' => $this->anneeAcademique,
            'entete4' => $this->entete4,
        ]);
    }
}

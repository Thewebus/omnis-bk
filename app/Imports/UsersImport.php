<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Classe;
use App\Models\Inscription;
use App\Models\AnneeAcademique;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public $anneeAcademique;

    function __construct() {
        $this->anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
    }

    public function model(array $row)
    {
        $classe = Classe::where('code', $row['code_classe'])->first();

        if(is_null($classe)) {
            $etudiant = User::all()->last();
            return $etudiant;
        }

        $etudiant = User::create([
            'fullname' => $row['nom_prenom'],
            'date_naissance' => str_replace('.', '-' , $row['date_nais']),
            'lieu_naissance' => $row['lieu_nais'],
            'numero_etudiant' => $row['contact'],
            'email'=> $row['email'],
            'cursus' => 'jour',
            'sexe'    => $row['sexe'],
            'statut' => $row['statut'], 
            'password' => Hash::make('password'),
            'nationalite' => $row['nationalite'], 
            'matricule_etudiant'    => $row['matricule'], 
            'domicile' => $row['domicile'],
            'etablissement_origine' => $row['etab_origine'],
            'adresse_geographique' => $row['add_geo'],
            'niveau_etude' => $row['niveau_etd'],
            'autre_diplome' => $row['autre_dipl'],
            'serie_bac' => $row['serie_bac'],
            'premier_entree_ua' => $row['1ere_entree_ua'],
            'responsable_legal' => $row['resp_legal'],
            'responsable_legal_precision' => $row['resp_legal_precision'],
            'responsable_legal_fullname' => $row['nom_prenom_resp_legal'],
            'responsable_legal_profession' => $row['resp_legal_profession'],
            'responsable_legal_adresse' => $row['resp_leg_adr'],
            'responsable_legal_domicile' => $row['resp_leg_dom'],
            'responsable_legal_numero' => $row['resp_leg_numero'],
            'classe_id' => $classe->id,
        ]);

        if ($row['statut'] == 'affecté') {
            $scolarite = $classe->niveauFaculte->scolarite_affecte;
        } else if ($row['statut'] == 'non affecté') {
            $scolarite = $classe->niveauFaculte->scolarite_nonaffecte;
        }
        else {
            $scolarite = $classe->niveauFaculte->scolarite_reaffecte;    
        }

        Inscription::create([
            'frais_inscription' => $scolarite,
            'net_payer' => $scolarite,
            'user_id' => $etudiant->id,
            'valide' => 1,
            'annee_academique_id' => $this->anneeAcademique->id,
        ]);

        return $etudiant;
    }
}

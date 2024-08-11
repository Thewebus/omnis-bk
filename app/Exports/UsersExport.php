<?php

namespace App\Exports;

use App\Models\User;
use App\Models\AnneeAcademique;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $anneeAcademique = getSelectedAnneeAcademique() ? getSelectedAnneeAcademique() : getLastAnneeAcademique();
        return User::whereHas('inscriptions', function(Builder $query) use ($anneeAcademique) {
            $query->where('annee_academique_id', $anneeAcademique->id)->where('valide', 1);
        })->select(
                "fullname", "email", 'date_naissance', 'lieu_naissance', 'statut', 'sexe', 'nationalite', 'matricule_etudiant', 'domicile', 'etablissement_origine', 'adresse_geographique', 'niveau_etude', 'autre_diplome',
                'serie_bac', 'premier_entree_ua', 'responsable_legal', 'responsable_legal_precision', 'responsable_legal_fullname', 'responsable_legal_profession', 'responsable_legal_adresse', 'responsable_legal_domicile', 'responsable_legal_numero'
            )->orderBy('fullname', 'ASC')->get();     
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return [
            "Nom & Prénom", "Email", 'Date Nais.', 'Lieu Nais.', 'Statut','Sexe', 'Nationnalité', ' Matricule', 'Domicile', 'Etab. Origine', 'Add. Geo', 'Niveau Etd', 'Autre dipl.',
            'Serie BAC', '1ère Entrée UA', 'Resp. légal', 'Resp. légal précision', 'Nom & Prénom Resp. légal', 'Resp. Legal Profession', 'Resp. Leg. Adr.', 'Resp Leg. Dom', 'Resp. Leg. numero'
        ];
    }
}
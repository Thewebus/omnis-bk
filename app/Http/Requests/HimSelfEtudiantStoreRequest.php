<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class HimSelfEtudiantStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nom_complet' => 'required|string',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string',
            'nationalite' => 'required|string',
            'sexe' => 'required|in:masculin,feminin',
            'domicile' => 'required|string',
            'numero' => ['required', 'digits:10', Rule::unique('users', 'numero_etudiant')->ignore(Auth::id())],
            'email' => ['nullable', Rule::unique('users', 'email')->ignore(Auth::id())],
            'etablissement_origine' => 'required|string',
            'adresse_geographique' => 'required|string',
            'niveau_etude' => 'nullable|string',
            'autre_diplome' => 'nullable|string',
            'serie_bac' => 'required|string',
            // 'statut' => 'required|in:affecté,non affecté,réaffecté',
            'niveau_etude_2' => 'required|string',
            // 'faculte' => 'required|integer',
            'date_premiere_entree' => ['required', 'digits:4'],
            // 'classe' => ['required', 'integer'],
            // 'matricule' => ['required', 'string'],
            'responsable_legal' => 'required|string',
            'responsable_legal_precision' => 'nullable|string',
            'responsable_legal_fullname' => 'required|string',
            'responsable_legal_profession' => 'required|string',
            'responsable_legal_adresse' => 'nullable|string',
            'responsable_legal_domicile' => 'required|string',
            'responsable_legal_numero' => 'required|string',
            
            // 'responsable_scolarite_fullname' => 'required|string',
            // 'responsable_scolarite_profession' => 'required|string',
            // 'responsable_scolarite_numero' => 'required|string',
            // 'responsable_scolarite_adresse' => 'required|string',
            // 'responsable_scolarite_domicile' => 'required|string',

            'fiche_inscription' => 'nullable|mimes:pdf|max:5120',
            'fiche_oriantation' => 'nullable|mimes:pdf|max:5120',
            'extrait_naissance' => 'nullable|mimes:pdf|max:5120',
            'bac_legalise' => 'nullable|mimes:pdf|max:5120',
            'cp_note_bac' => 'nullable|mimes:pdf|max:5120',
            'photo' => 'nullable|mimes:png,jpg,jpeg|max:5120',
        ];
    }
}

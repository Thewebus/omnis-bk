<?php

namespace App\Rules;

use App\Models\Matiere;
use Illuminate\Contracts\Validation\Rule;

class MatiereProfesseurAvaibleRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($matiere = null)
    {
        $this->matiere = $matiere;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        Matiere::isMatiereAvaible($value, request()->input('professeur'));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Le professeur enseigne déjà cette matière.';
    }
}

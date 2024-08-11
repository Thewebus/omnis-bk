<?php

namespace App\Rules;

use App\Models\Cours;
use Illuminate\Contracts\Validation\Rule;

class CoursTimeAvailabilityRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    public $cours;
    public function __construct($cours = null)
    {
        $this->cours = $cours;
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
        return Cours::isTimeAvailable(request()->input('jour'), $value, request()->input('heure_fin'), request()->input('classe'), request()->input('salle'), $this->cours);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Cette heure est déjà utilisée';
    }
}

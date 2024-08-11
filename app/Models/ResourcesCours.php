<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourcesCours extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function classe() {
        return $this->belongsTo(Classe::class);
    }

    public function professeur() {
        return $this->belongsTo(Professeur::class);
    }

    public function matiere() {
        return $this->belongsTo(Matiere::class);
    }

    public function anneeAcademique() {
        return $this->belongsTo(AnneeAcademique::class);
    }
}

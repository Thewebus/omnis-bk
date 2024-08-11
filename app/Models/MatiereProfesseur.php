<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MatiereProfesseur extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'matiere_professeur';
    protected $guarded = [];

    public function professeur() {
        return $this->belongsTo(Professeur::class);
    }

    public function matiere() {
        return $this->belongsTo(Matiere::class);
    }

    public function classe() {
        return $this->belongsTo(Classe::class);
    }
}

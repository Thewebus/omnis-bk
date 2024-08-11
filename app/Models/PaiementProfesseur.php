<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaiementProfesseur extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $cast = ['date_paiement' => 'date'];

    public function professeur() {
        return $this->belongsTo(Professeur::class);
    }

    public function personnel() {
        return $this->belongsTo(Personnel::class);
    }

    public function faculte() {
        return $this->belongsTo(Faculte::class);
    }

    public function anneeAcademique() {
        return $this->belongsTo(AnneeAcademique::class);
    }
}

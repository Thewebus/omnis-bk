<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $casts = [
        'notes_selectionnees' => 'array'
    ];

    // public function classe() {
    //     return $this->belongsTo(Classe::class);
    // }

    public function professeur() {
        return $this->belongsTo(Professeur::class);
    }

    public function etudiant() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function matiere() {
        return $this->belongsTo(Matiere::class);
    }

    public function anneeAcademique() {
        return $this->belongsTo(AnneeAcademique::class);
    }
}

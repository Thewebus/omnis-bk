<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    use HasFactory;

    const reclamations_type = [
        'error_fullname' => 'Erreur sur le nom',
        'verification_notes' => 'Vérification notes',
        'error_notes' => 'Erreur sur les notes',
        'omission_note' => 'Omission des notes'
    ];

    protected $guarded = [];
    protected $casts = [
        'reclamation_type' => 'array'
    ];

    public function etudiant() {
        return $this->belongsTo(User::class);
    }
}

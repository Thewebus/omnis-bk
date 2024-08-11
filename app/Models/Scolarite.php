<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scolarite extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function etudiant() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function anneeAcademique() {
        return $this->belongsTo(AnneeAcademique::class);
    }
}

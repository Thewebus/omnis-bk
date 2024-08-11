<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NiveauFaculte extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = []; 


    public function faculte() {
        return $this->belongsTo(Faculte::class);
    }

    public function classes() {
        return $this->hasMany(Classe::class);
    }

    public function matieres() {
        return $this->hasManyThrough(Matiere::class, Classe::class);
    }
}

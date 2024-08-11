<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnneeAcademique extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function classes() {
        return $this->hasMany(Classe::class);
    }

    public function tests() {
        return $this->hasMany(Test::class);
    }

    public function presences() {
        return $this->hasMany(Presence::class);
    }

    public function notes() {
        return $this->hasMany(Note::class);
    }

    public function scolarites() {
        return $this->hasMany(Scolarite::class);
    }

    public function cours() {
        return $this->hasMany(Cours::class);
    }

    public function anneeAcademiquePrecedente() {
        return $this->where('id', '<', $this->id)->orderBy('id', 'desc')->first();
    }
}

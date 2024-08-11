<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Professeur extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'modules_enseignes' => 'array',
    ];

    public function classes() {
        return $this->belongsToMany(Classe::class);
    }

    public function instituts() {
        return $this->belongsToMany(Institut::class);
    }

    public function matieres() {
        return $this->belongsToMany(Matiere::class)->withPivot('volume_horaire', 'progression', 'statut', 'classe_id', 'annee_academique_id')->withTimestamps();
    }

    public function presences() {
        return $this->hasMany(Presence::class);
    }

    public function notes() {
        return $this->hasMany(Note::class);
    }

    public function cahierTextes() {
        return $this->hasMany(CahierTexte::class);
    }

    public function ressourcesCours() {
        return $this->hasMany(ResourcesCours::class);
    }

    public function matiereProfesseur() {
        return $this->hasMany(MatiereProfesseur::class);
    }

    public function paiementProfesseurs() {
        return $this->hasMany(PaiementProfesseur::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
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
        'date_naissance' => 'datetime',
    ];

    public function classe(int $anneeAcademiqueId) {
        return $this->inscriptions->firstWhere('annee_academique_id', $anneeAcademiqueId)->classe ?? 'No classe';
    }

    public function cursus() {
        return $this->belongsTo(Cursus::class);
    }

    public function niveauFaculte() {
        return $this->belongsTo(NiveauFaculte::class);
    }

    public function notes() {
        return $this->hasMany(Note::class);
    }

    public function scolarites() {
        return $this->hasMany(Scolarite::class);
    }

    public function echeancier(int $anneeAcademiqueId) {
        return $this->hasMany(Echeancier::class)->firstWhere('annee_academique_id', $anneeAcademiqueId);
    }

    public function echeanciers() {
        return $this->hasMany(Echeancier::class);
    }

    public function inscriptions() {
        return $this->hasMany(Inscription::class);
    }

    public function inscription($anneeAcademiqueId) {
        return $this->inscriptions->firstWhere('annee_academique_id', $anneeAcademiqueId); 
    }

    public function heureAbsences() {
        return $this->hasMany(HeureAbsence::class);
    }

    public function reclamations() {
        return $this->hasMany(Reclamation::class);
    }

    public function messages() {
        return $this->morphMany(ChatMessage::class, 'chat_messageable');
    }
}

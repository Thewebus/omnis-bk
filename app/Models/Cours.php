<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Cours extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    const JOURS = [
        '1' => 'Lundi',
        '2' => 'Mardi',
        '3' => 'Mercredi',
        '4' => 'Jeudi',
        '5' => 'Vendredi',
        '6' => 'Samedi',
        '7' => 'Dimanche',
    ];

    public function difference() {
        $heureDebut = Carbon::parse($this->heure_debut);
        $heureFin = Carbon::parse($this->heure_fin);
        return $heureFin->diffInMinutes($heureDebut);
    }

    public function getStartTimeAttribute($value) {
        return $value ? Carbon::createFromFormat('H:i:s', $value)->format('H:i') : null;
    }

    public function setStartTimeAttribute($value) {
        $this->attributes['heure_debut'] = $value ? Carbon::createFromFormat('H:i:s', $value)->format('H:i') : null;
    }

    public function getEndTimeAttribute($value) {
        return $value ? Carbon::createFromFormat('H:i:s', $value)->format('H:i') : null;
    }

    public function setEndTimeAttribute($value) {
        $this->attributes['heure_fin'] = $value ? Carbon::createFromFormat('H:i:s', $value)->format('H:i:s') : null;
    }

    public function classe() {
        return $this->belongsTo(Classe::class);
    }

    public function matiere() {
        return $this->belongsTo(Matiere::class);
    }

    public function salle() {
        return $this->belongsTo(Salle::class);
    }

    public function professeur() {
        return $this->belongsTo(Professeur::class);
    }

    // public function isSalleAvailable() {

    // }

    public static function isTimeAvailable($jour, $heureDebut, $heureFin, $classe, $salle, $cours) {
        $cours = self::where('jour', $jour)
            ->when($cours, function($query) use ($cours) {
                $query->where('id', '!=', $cours);
            })
            ->where(function($query) use ($classe, $salle) {
                $query->where('classe_id', $classe)
                ->orWhere('salle_id', $salle);
            })
            ->where([
                ['heure_debut', '<', $heureFin],
                ['heure_fin', '>', $heureDebut],
            ])
            ->count();

        return !$cours;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institut extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function professeurs() {
        return $this->belongsToMany(Professeur::class);
    }

    public function filieres() {
        return $this->hasMany(Filiere::class);
    }
}

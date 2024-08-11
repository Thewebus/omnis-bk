<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClasseProfesseur extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'classe_professeur';
    protected $guarded = [];

    
}

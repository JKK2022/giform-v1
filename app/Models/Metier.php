<?php

namespace App\Models;

use App\Models\Filiere;
use App\Models\TypeFormation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Metier extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function typeformation_metier()
    {
        return $this->belongsTo(TypeFormation::class,"type_formation_id","id");
    }

    public function filiere_metier()
    {
        return $this->belongsTo(Filiere::class,"filiere_id","id");
    }
}

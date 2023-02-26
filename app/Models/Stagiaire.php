<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stagiaire extends Model
{
    use HasFactory;

    protected $fillable = [
        "matricule",
        "nom",
        "postnom",
        "prenom",
        "sexe",
        "lieu_naissance",
        "date_naissance",
        "telephone1",
        "telephone2",
        "email",
        "adresse",
        "nom_pere",
        "nom_mere"
    ];

    public function photo(){
        return $this->hasOne(PhotoStagiaire::class,'stagiaire_id','id');
    }   
}

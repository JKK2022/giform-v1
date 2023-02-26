<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoStagiaire extends Model
{
    use HasFactory;

    protected $table = "photo_stagiaires";

    protected $fillable = [
        'stagiaire_id',
        'photo'
    ];  
}

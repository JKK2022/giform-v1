<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function typeformation_module()
    {
        return $this->belongsTo(TypeFormation::class,"type_formation_id","id");
    }

    public function filiere_module()
    {
        return $this->belongsTo(Filiere::class,"filiere_id","id");
    }
}

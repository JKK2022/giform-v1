<?php

namespace App\Models;

use App\Models\Metier;
use App\Models\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TypeFormation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function modules_type()
    {
        return $this->hasMany(Module::class);
    }

    public function metiers_type()
    {
        return $this->hasMany(Metier::class);
    }
}

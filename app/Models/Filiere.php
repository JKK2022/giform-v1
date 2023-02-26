<?php

namespace App\Models;

use App\Models\Metier;
use App\Models\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Filiere extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = ['nom','service_id'];

    public function service()
    {
        return $this->belongsTo(Service::class,"service_id","id");
    }

    public function modules_filiere()
    {
        return $this->hasMany(Module::class);
    }

    public function metiers_filiere()
    {
        return $this->hasMany(Metier::class);
    }
}

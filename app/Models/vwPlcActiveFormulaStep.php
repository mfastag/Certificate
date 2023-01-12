<?php

namespace App\Models;
use App\Scopes\PlantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vwPlcActiveFormulaStep extends Model
{
    use HasFactory;
    protected $table = 'vwPlcActiveFormulaStep';
    protected static function booted()
    {
        static::addGlobalScope(new PlantScope);
    }    

}

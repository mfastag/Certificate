<?php

namespace App\Models;
use App\Scopes\PlantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblCip_Plants extends Model
{
    use HasFactory;
    protected $table = 'tblCip_Plants';


   // protected static function booted()
   // {
   //     static::addGlobalScope(new PlantScope);
   // }  
    
}

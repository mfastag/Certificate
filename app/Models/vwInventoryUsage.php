<?php

namespace App\Models;

use App\Scopes\PlantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vwInventoryUsage extends Model
{
    use HasFactory;
    protected $table = 'vwInventoryUsage';
    
    
    
    protected static function booted()
    {
        static::addGlobalScope(new PlantScope);
    }
}

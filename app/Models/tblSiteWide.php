<?php

namespace App\Models;
use App\Scopes\PlantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblSiteWide extends Model
{
    use HasFactory;
//    protected $table = 'vwSiteWideData';
    protected $table = 'vwSiteWideData';
    
    protected $primaryKey = 'id';
    public $timestamps = false;

//'string', 'number', 'boolean', 'date', 'datetime', and 'timeofday'.

    static $cast = [
        'DurationHours' => 'number',
        'Start Date/Time' => 'datetime'
    ];
    
    protected static function booted()
    {
        static::addGlobalScope(new PlantScope);
    }
}

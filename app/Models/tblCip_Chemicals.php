<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblCip_Chemicals extends Model
{
    use HasFactory;
    protected $table = 'vwCip_Chemicals';
    protected $primaryKey = 'id';
    public $timestamps = false;





}

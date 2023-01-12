<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblCip_Chemical_log extends Model
{
    use HasFactory;
    protected $table = 'tblCip_Chemical_log';
    protected $primaryKey = 'id';
    public $timestamps = false;

}

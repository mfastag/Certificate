<?php

namespace App\Models;
use App\Scopes\PlantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblUser_Mst_Rights extends Model
{
    use HasFactory;
    protected $table = 'tblUser_Mst_Rights';
    protected $primaryKey = 'id';
    public $timestamps = false;


    // do not put any User Scopes on this model.

}

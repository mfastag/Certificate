<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

   

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles() {
        $roles=tblUser_Mst_Rights::select("role_type as role")
        ->where('tblUser_Mst_id', $this->id)
        ->distinct()->get();

        $results=[];
        foreach($roles as $role) {
            $results[$role->role]=$role->role;
        }

        return $results;


    }

    public function plants()
    {
//        $plants = $this->hasMany('App\Models\tblUser_Mst_Rights','tblUser_Mst_id','id')->where('role_type','=', 'Plant')->whereNotNull('role_value')->select('role_value');
        
        $plants = tblUser_Mst_Rights::select("role_value as Plant")
          ->where('tblUser_Mst_id','=',$this->id)
          ->where('role_type','=', 'Plant')
          ->whereNotNull('role_value')
          ->orderBy('role_value')
          ->get();
          
/* if(count($plants)>0){
            return $plants;
        }
        else{
            $plants = tblCip_Plants::select("PlantName as Plant")->orderBy('PlantName')->get();
        }
*/        
        return $plants;
    }



}

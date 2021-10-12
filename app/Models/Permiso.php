<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;
    protected $table =  'permisos';
    public $timestamps = false;
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'menu',
         'cliente', 
         'usuario', 
         'ticket', 
         'reporte', 
         'config',
         'sistema',
         'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    # [Relaciones] #
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    # [Relacion con hijos] #
    public function permisoscamus()
    {
        return $this->hasOne(Camus\Permiso::class,'permiso_id','id');
    }
    

    # [Metodos Particulares] #
    static public function actualizar(User $user,$permisoValue){
                
        $user->permisos->menu = $permisoValue['menu'];
        $user->permisos->ticket=$permisoValue['ticket'];
        $user->permisos->usuario=$permisoValue['usuario'];
        $user->permisos->config=$permisoValue['config'];
        $user->permisos->sistema=$permisoValue['sistema'];

        if(isset($permisoValue['cliente'])){
            $user->permisos->cliente=$permisoValue['cliente'];
        }

        if(isset($permisoValue['producto'])){
            $user->permisos->producto=$permisoValue['producto'];
        }
        
        if(isset($permisoValue['reporte'])){
            $user->permisos->reporte=$permisoValue['reporte'];
        }
        

        $user->permisos->update();
    }
    static public function crear(User $user,$permisoValue){
        $permisos=(new Permiso);
               
        $permisos->menu=json_encode($permisoValue['menu']);
        $permisos->usuario=json_encode($permisoValue['usuario']);
        $permisos->ticket=json_encode($permisoValue['ticket']);
        $permisos->config=json_encode($permisoValue['config']);
        $permisos->sistema=json_encode($permisoValue['sistema']);
        
        $permisos->user_id=$user->id;
        $permisos->save();
        
    }
}

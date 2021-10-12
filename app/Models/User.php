<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table =  'users';
    public $timestamps = true;
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path', 
        'tipo_id', 
        'cliente_id',
        'empresa_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret', 
        'two_factor_recovery_codes',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    # [Relaciones] #
    public function permisos()
    {
        return $this->hasOne(Permiso::class,'user_id','id')->with('permisoscamus');
    }
    public function tipo()
    {
        return $this->hasOne(Tipo::class,'id','tipo_id');
    }
    public function cliente()
    {
        return $this->hasOne(Cliente::class,'id','cliente_id');
    }
    public function empresa()
    {
        return $this->hasOne(Empresa::class,'id','empresa_id');
    }
    
    /* [Relaciones con los modelos Hijos] */
    public function userCamus()
    {
        return $this->hasOne(Camus\User::class,'user_id','id')->with('zona','tipo','permisos');
    }

}

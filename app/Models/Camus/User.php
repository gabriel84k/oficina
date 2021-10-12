<?php

namespace App\Models\Camus;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table =  'camus_users';
    public $timestamps = true;
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'camus_tipo_id',
        'camus_zona_id',
        'estado', 
        'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'email_verified_at',
        'created_at', 
        'updated_at', 
        
        'email',
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

   
    public function permisos()
    {
        return $this->hasOne(Permiso::class,'camus_user_id','id');
    }
    public function ctasctes()
    {
        return $this->hasMany(Ctacte::class);
    }
    public function tipo()
    {
        return $this->hasOne(Tipo::class,'id','camus_tipo_id');
    }
    public function zona(){
        return $this->belongsToMany(Zona::class,'camus_users_zonas')->withPivot('zona_id');
    }
    
    # [Relación al Modelo Padre] #
    public function userAioros()
    {
        return $this->hasOne(App\Models\User::class,'id','user_id');
    }
}

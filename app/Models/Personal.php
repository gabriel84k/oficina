<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;
    protected $table =  'personals';
    public $timestamps = true;
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'nombreApellido',
        'edad',
        'domicilio',
        'telefono' ,
        'observacion' ,
        'foto' ,
        'temporal',
        'estado',
        'user_id',
        'empresa_id'
       
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
    # [ Relaciones ] #
    public function user()
    {
        return $this->hasOne(User::class,'cliente_id','id');
    }
    public function empresa()
    {
        return $this->hasOne(Empresa::class,'id','empresa_id');
    }
    public function red()
    {
        return $this->belongsToMany(Red::class,'personal_id','id');
    }

}

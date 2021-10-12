<?php

namespace App\Models\MU;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Cliente;

class Presupuesto extends Model
{
    use HasFactory;
    protected $table =  'mu_presupuestos';
    public $timestamps = true;
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        
        'fecha', 
        'direccion', 
        'total', 
        'titulo',
        'nota', 
        'firma',
        'estado', 
        'cliente_id', 
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
    public function cliente()
    {
        return $this->hasOne(Cliente::class,'id','cliente_id');
    }
}

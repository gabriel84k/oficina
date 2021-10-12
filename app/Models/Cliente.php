<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;



class Cliente extends Model
{
    use HasFactory;
    protected $table =  'clientes';
    public $timestamps = true;
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 
        'detalle', 
        'provincia', 
        'nota',
        'telefono',
        'celular'
        
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
        return $this->hasOne(User::class,'cliente_id','id');
    }
    public function ticket()
    {
        return $this->hasOne(Ticket::class,'cliente_id','id');
    }
}

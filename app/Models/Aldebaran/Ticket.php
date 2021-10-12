<?php

namespace App\Models\Aldebaran;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use App\Models\Aldebaran\Sistema;
use App\Models\Aldebaran\TicketDetalle;

class Ticket extends Model
{
    use HasFactory;
    protected $table =  'aldebaran_tikects';
    public $timestamps = true;
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'estado', 
        'prioridad',
        'sistema_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'cliente_id', 
         
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    # [Relaciones] #

    public function detalleticket(){
        return $this->hasMany(TicketDetalle::class,'tikect_id','id')->orderBy('updated_at', 'desc');
    }
    public function sistema(){
        return $this->hasOne(Sistema::class,'id','sistema_id');
    }
    public function cliente(){
        return $this->hasOne(Cliente::class,'id','cliente_id');
    }

}

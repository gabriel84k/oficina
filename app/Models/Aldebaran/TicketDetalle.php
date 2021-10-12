<?php

namespace App\Models\Aldebaran;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class TicketDetalle extends Model
{
    use HasFactory;
    protected $table =  'aldebaran_ticket_detalles';
    public $timestamps = true;
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo', 
        'titulo', 
        'detalle',
        'user_id',
        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'tikect_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    # [Relaciones] #
    
    public function ticket(){
        return $this->hasOne(Ticket::class,'id','tikect_id');
    }
    public function tecnico(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function foto(){
        return $this->hasMany(Foto::class,'aldebaran_ticket_detalle_id','id');
    }
}

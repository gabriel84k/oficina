<?php

namespace App\Models\Aldebaran;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;
    protected $table =  'aldebaran_fotos';
    public $timestamps = false;
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'nombre', 'descripcion', 'aldebaran_ticket_detalle_id'
        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'aldebaran_ticket_detalle_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    # [Relaciones] #
    public function ticketdetalle()
    {
        return $this->hasOne(TicketDetalle::class,'id','aldebaran_ticket_detalle_id');
    }
}

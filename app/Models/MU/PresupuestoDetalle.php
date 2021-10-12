<?php

namespace App\Models\MU;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresupuestoDetalle extends Model
{
    use HasFactory;
    protected $table =  'mu_presupuestodetalles';
    public $timestamps = false;
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'detalle', 'precio', 'cantidad', 'total', 'presupuesto_id'
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
    public function presupuesto()
    {
        return $this->hasOne(Presupuesto::class,'id','presupuesto_id');
    }

}
